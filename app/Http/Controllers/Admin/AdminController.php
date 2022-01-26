<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function showLogin()
    {
        return response()->json(["Admin Login Page"]);
    }

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

    public function showRegister()
    {
        return response()->json(["Admin Registration Page"]);
    }

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

    public function logout(Request $request)
    {
        Auth::guard("admin")->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route("admin.login.create");
    }

    public function dashboard(Request $request)
    {
        return response()->json([
            "Admin Dashboard" => Auth::guard("admin")->user(),
        ]);
    }
}
