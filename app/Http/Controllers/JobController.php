<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
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
        return back()->withSuccess("Job has been created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        $this->authorize("viewAny", Job::class);
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
        return back()->withSuccess("Job updated successfully!");
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
        return back()->withSuccess("Job status successfully changed.");
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
        return back()->withSuccess("Job deleted successfully.");
    }

    /**
     * Render all the jobs for a specific student.
     */
    public function myJobs(Request $request)
    {
        return Inertia::render("Jobs/StudentJobs", [
            "jobs" => $request->user()->jobs,
        ]);
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
}
