<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render("Auth/Register");
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                "first_name" => "required|string|max:255",
                "last_name" => "required|string|max:255",
                "ncu_id" =>
                    "required|string|max:255|unique:users,ncu_id|unique:admins,ncu_id",
                "dob" => "required|date",
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
                "dob.required" => "Please enter your D.o.B.",
                "email.required" => "Please enter an email address.",
                "email.email" => "Please enter a valid email address.",
                "password.required" => "Please enter your password.",
                "password.confirmed" =>
                    "Password and Confirm Password should be the same.",
            ],
        );

        $user = User::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "ncu_id" => $request->ncu_id,
            "dob" => $request->dob,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
