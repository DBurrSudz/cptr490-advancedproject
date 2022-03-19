<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Booking;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("viewAll", Job::class);
        if (Auth::guard("admin")->check()) {
            $jobs = Job::select([
                "id",
                "title",
                "approved",
                "created_at",
                "user_id",
                "admin_id",
                "date_posted",
                "request",
            ])
                ->latest()
                ->with([
                    "user:id,first_name,last_name",
                    "admin:id,first_name,last_name",
                ])
                ->get();
        } else {
            $jobs = Job::select([
                "id",
                "title",
                "date_posted",
                "updated_at",
                "paid",
                "rate",
                "user_id",
                "request",
            ])
                ->where("approved", 1)
                ->latest()
                ->with("user:id,first_name,last_name")
                ->withCount("comments")
                ->get();
        }
        return Inertia::render("Jobs/JobsIndex", ["jobs" => $jobs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Jobs/CreateEdit", ["mode" => "create"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        $this->authorize("create", Job::class);
        Job::create($request->validated());
        if ($request->input("request")) {
            return back()->withSuccess("Request created.");
        }
        return back()->withSuccess("Job created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Job $job)
    {
        $this->authorize("viewAny", Job::class);
        if (!$job->request) {
            $comments = $job
                ->comments()
                ->with("user")
                ->get();
            return Inertia::render("Jobs/ViewJob", [
                "job" => $job,
                "user" => $job->user,
                "comments" => $comments,
                "commentsCount" => $job->comments()->count(),
            ]);
        }
        if (Auth::guard("web")->check()) {
            $user = $request->user("web");
            $applied = !empty(
                $user
                    ->bookings()
                    ->where("job_id", $job->id)
                    ->first()
            )
                ? true
                : false;
        }
        return Inertia::render("Jobs/ViewJob", [
            "job" => $job,
            "user" => $job->user,
            "applied" => $applied ?? null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return Inertia::render("Jobs/CreateEdit", [
            "mode" => "edit",
            "job" => $job,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        $this->authorize("editAndUpdate", $job);
        $job->update($request->validated());
        if ($request->input("request")) {
            return back()->withSuccess("Request updated.");
        }
        return back()->withSuccess("Job updated.");
    }

    /**
     * Changes the approval status of a job. If the job is currently unapproved,
     * it is switched to approved with the datetime of approval and the ID
     * of the currently logged in admin who is doing the approval are stored. If the job is currently,
     * approved, then it is switched to unapproved and the date posted and admin id fields are
     * set to null.
     * @param  \App\Models\Job  $job
     */
    public function approveAndDisapproveJob(Job $job)
    {
        $this->authorize("approveAndDisapproveJobs", Job::class);
        if (!$job->approved) {
            $job->update([
                "date_posted" => date("Y-m-d H:i:s"),
                "admin_id" => Auth::guard("admin")->id(),
                "approved" => 1,
            ]);
        } else {
            $job->update([
                "date_posted" => null,
                "admin_id" => null,
                "approved" => 0,
            ]);
        }
        return back()->withSuccess("Status updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $this->authorize("destroy", $job);
        $job->delete();
        return back()->withSuccess("Deleted successfully.");
    }

    /**
     * Render all the jobs for a specific student.
     */
    public function myJobs(Request $request)
    {
        return Inertia::render("Jobs/StudentJobs", [
            "jobs" => $request
                ->user()
                ->jobs()
                ->where("request", 0)
                ->latest()
                ->get(),
            "requests" => $request
                ->user()
                ->jobs()
                ->where("request", 1)
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Render all the applicants for a specific job request.
     */
    public function jobBookings(Job $job)
    {
        $bookings = $job
            ->bookings()
            ->with("user:id,first_name,last_name")
            ->latest()
            ->get();

        return Inertia::render("Jobs/Bookings", ["bookings" => $bookings]);
    }

    /**
     * Allows students to upload images while creating a job.
     */
    public function uploadImage(Request $request)
    {
        $fileName = $request->file("file")->getClientOriginalName();
        $path = $request->file("file")->storeAs("uploads", $fileName, "public");
        return response()->json(["location" => "/storage/{$path}"]);
    }

    /**
     * Closes a job to prevent others from apply. When a job is closed, all users not accepted for the job will know.
     */
    public function toggleClosed(Job $job)
    {
        if (!$job->closed) {
            $job->update([
                "closed" => 1,
            ]);
        } else {
            $job->update([
                "closed" => 0,
            ]);
        }
        return back()->withSuccess("Status updated.");
    }
}
