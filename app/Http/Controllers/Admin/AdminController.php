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
        return Inertia::render("Auth/Login");
    }

    /**
     * Authenticates an admin.
     */
    public function login(Request $request)
    {
        $request->validate(
            [
                "email" => "required_without:ncu_id|email",
                "ncu_id" => "required_without:email",
                "password" => "required|string",
            ],
            [
                "email.required_without" =>
                    "Please enter either an email address or your NCU ID.",
                "ncu_id.required_without" =>
                    "Please enter either an email address or your NCU ID.",
                "password.required" => "Please enter your password.",
                "email.email" => "Please enter a valid email address.",
            ],
        );

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
        return Inertia::render("Auth/Register", ["titles" => Admin::TITLES]);
    }

    /**
     * Registers an admin in the system.
     */
    public function register(Request $request)
    {
        $request->validate(
            [
                "first_name" => "required|string|max:255",
                "last_name" => "required|string|max:255",
                "ncu_id" =>
                    "required|string|max:255|unique:admins,ncu_id|unique:users,ncu_id",
                "title" => "required|string|max:255",
                "position" => "required|string|max:255",
                "email" =>
                    "required|string|email|max:255|unique:users,email|unique:admins,email",
                "password" => [
                    "required",
                    "confirmed",
                    Rules\Password::defaults(),
                ],
            ],
            [
                "first_name.required" => "Please enter your Firstname.",
                "first_name.max" =>
                    "First Name should not exceed 255 characters.",
                "last_name.required" => "Please enter your Lastname.",
                "last_name.max" =>
                    "Last Name should not exceed 255 characters.",
                "ncu_id.required" => "Please enter your NCU ID.",
                "ncu_id.max" => "NCU ID should not exceed 255 characters.",
                "ncu_id.unique" => "NCU ID already exists.",
                "title.required" => "Please select a title.",
                "position.required" =>
                    "Please enter your official position held.",
                "position.max" => "Position should not exceed 255 characters.",
                "email.required" => "Please enter an email address.",
                "email.email" => "Please enter a valid email address.",
                "password.required" => "Please enter your password.",
                "password.confirmed" =>
                    "Password and Confirm Password should be the same.",
            ],
        );

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
            ->get(["id", "title", "user_id", "date_posted", "created_at"]);
        $announcementsPostedCount = $admin->announcements()->count();
        $jobsApprovedCount = $admin->jobs()->count();
        $jobsUnapproved = Job::where("approved", 0)->count();

        return Inertia::render("Dashboard", [
            "announcements" => $announcements,
            "jobsAdmin" => $jobs,
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
