<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $jobs = $user
            ->jobs()
            ->latest()
            ->with("admin:id,first_name,last_name")
            ->take(5)
            ->get([
                "id",
                "title",
                "date_posted",
                "created_at",
                "admin_id",
                "approved",
            ]);
        $unapprovedCount = $user
            ->jobs()
            ->where("approved", 0)
            ->count();

        $jobsCreatedCount = $user->jobs()->count();

        $comments = $user
            ->comments()
            ->latest()
            ->with("job:id,title")
            ->take(3)
            ->get(["id", "body", "job_id", "created_at", "updated_at"]);

        return Inertia::render("Dashboard", [
            "jobsStudent" => $jobs,
            "unapprovedCount" => $unapprovedCount,
            "comments" => $comments,
            "jobsCreatedCount" => $jobsCreatedCount,
        ]);
    }

    /**
     * Renders the profile page for a student.
     */
    public function profile(Request $request)
    {
        return response()->json(["user" => $request->user]);
    }

    /**
     * Allows students to update their profile.
     */
    public function update(StudentRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json([
            "Student Profile has been updated successfully.",
        ]);
    }

    /**
     * Shows a student's public profile to users of the system.
     */
    public function show(User $user)
    {
        return response()->json(["user" => $user]);
    }
}
