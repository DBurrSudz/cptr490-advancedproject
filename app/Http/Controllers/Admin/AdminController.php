<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AdminController extends Controller
{
    /**
     * Renders the admin login screen.
     */
    public function showLogin()
    {
        return response()->json(["Admin Login Page"]);
    }

    /**
     * Authenticates an admin.
     */
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required_without:ncu_id",
            "ncu_id" => "required_without:email",
            "password" => "required|string",
        ]);

        $admin = Admin::where("email", $request->input("email"))
            ->orWhere("ncu_id", $request->input("ncu_id"))
            ->first();

        if (
            $admin &&
            Hash::check($request->input("password"), $admin->password)
        ) {
            Auth::guard("admin")->login($admin);

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME_ADMIN);
        }

        throw ValidationException::withMessages([
            "email" => __("auth.failed"),
        ]);
    }

    /**
     * Renders the registration screen for an admin
     */
    public function showRegister()
    {
        return response()->json(["Admin Registration Page"]);
    }

    /**
     * Registers an admin in the system.
     */
    public function register(Request $request)
    {
        $request->validate([
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "ncu_id" =>
                "required|string|max:255|unique:admins,ncu_id|unique:users,ncu_id",
            "title" => "required|string|max:255",
            "position" => "required|string|max:255",
            "email" =>
                "required|string|email|max:255|unique:users,email|unique:admins,email",
            "password" => ["required", "confirmed", Rules\Password::defaults()],
        ]);

        $admin = Admin::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "ncu_id" => $request->ncu_id,
            "title" => $request->title,
            "position" => $request->position,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        Auth::guard("admin")->login($admin);

        return redirect(RouteServiceProvider::HOME_ADMIN);
    }

    /**
     * Logs an admin out of the system.
     */
    public function logout(Request $request)
    {
        Auth::guard("admin")->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route("admin.login.create");
    }

    /**
     * Renders the admin dashboard.
     */
    public function dashboard(Request $request)
    {
        $admin = $request->user("admin");
        $announcements = $admin
            ->announcements()
            ->latest()
            ->take(5)
            ->get(["id", "title", "category", "created_at", "updated_at"]);
        $jobs = $admin
            ->jobs()
            ->latest()
            ->with("user:id,first_name,last_name")
            ->take(5)
            ->get("title", "user_id", "date_posted");
        $announcementsPostedCount = $admin->announcements()->count();
        $jobsApprovedCount = $admin->jobs()->count();
        $jobsUnapproved = Job::where("approved", 0)->count();

        return response()->json([
            "admin" => Auth::guard("admin")->user(),
            "announcements" => $announcements,
            "jobs" => $jobs,
            "announcementsPostedCount" => $announcementsPostedCount,
            "jobsApprovedCount" => $jobsApprovedCount,
            "jobsUnapproved" => $jobsUnapproved,
        ]);
    }

    /**
     * Renders the profile page for an admin.
     */
    public function profile(Request $request)
    {
        return response()->json(["admin" => $request->user]);
    }

    /**
     * Allows admin to update their profile.
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $admin->update($request->validated());
        return response()->json(["Admin account successfully updated."]);
    }
}
