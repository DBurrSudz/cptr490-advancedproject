<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return Inertia::render("Welcome");
});

//----------------Admin Routes------------------------------------------

Route::group(
    ["prefix" => "admin", "middleware" => ["admin"], "as" => "admin."],
    function () {
        //Dashboard and Profile
        Route::get("/dashboard", [AdminController::class, "dashboard"])->name(
            "dashboard",
        );

        Route::get("/profile", [AdminController::class, "profile"])->name(
            "profile",
        );

        Route::put("/profile/{admin}", [
            AdminController::class,
            "update",
        ])->name("profile.update");

        //Announcements
        Route::get("manage-announcements", [
            AnnouncementController::class,
            "index",
        ])->name("announcements.index");

        Route::get("my-announcements", [
            AnnouncementController::class,
            "myAnnouncements",
        ])->name("my-announcements.index");

        Route::get("manage-announcements/create", [
            AnnouncementController::class,
            "create",
        ])->name("announcements.create");

        Route::get("manage-announcements/{announcement}", [
            AnnouncementController::class,
            "show",
        ])->name("announcements.show");

        Route::get("manage-announcements/{announcement}/edit", [
            AnnouncementController::class,
            "edit",
        ])->name("announcements.edit");

        //Jobs
        Route::get("manage-jobs", [JobController::class, "index"])->name(
            "jobs.index",
        );

        Route::get("manage-jobs/{job}", [JobController::class, "show"])->name(
            "jobs.show",
        );

        Route::put("manage-jobs/status/{job}", [
            JobController::class,
            "approveAndDisapproveJob",
        ])->name("jobs.status");
    },
);

//------------------Student Routes------------------------------------------
Route::group(["middleware" => ["auth"], "as" => "student."], function () {
    //Dashboard and Profile
    Route::get("/dashboard", [StudentController::class, "dashboard"])->name(
        "dashboard",
    );

    Route::get("/profile", [StudentController::class, "profile"])->name(
        "profile",
    );

    Route::put("/profile/{user}", [StudentController::class, "update"])->name(
        "profile.update",
    );

    //Bookings
    Route::get("/bookings", [BookingController::class, "index"])->name(
        "bookings.index",
    );

    //Announcements
    Route::get("/announcements", [
        AnnouncementController::class,
        "index",
    ])->name("announcements.index");
    Route::get("announcements/{announcement}", [
        AnnouncementController::class,
        "show",
    ])->name("announcements.show");

    //Jobs
    Route::get("jobs", [JobController::class, "index"])->name("jobs.index");
    Route::get("my-jobs", [JobController::class, "myJobs"])->name(
        "my-jobs.index",
    );
    Route::get("jobs/create", [JobController::class, "create"])->name(
        "jobs.create",
    );
    Route::get("jobs/{job}", [JobController::class, "show"])->name("jobs.show");
    Route::get("jobs/{job}/edit", [JobController::class, "edit"])->name(
        "jobs.edit",
    );
    Route::get("jobs/{job}/bookings", [
        JobController::class,
        "jobBookings",
    ])->name("jobs.bookings");
});

//---------------Resource Routes---------------------------------------------
Route::group(
    ["middleware" => ["admin"], "as" => "announcements."],
    function () {
        Route::post("/announcements", [
            AnnouncementController::class,
            "store",
        ])->name("store");
        Route::put("/announcements/{announcement}", [
            AnnouncementController::class,
            "update",
        ])->name("update");
        Route::delete("/announcements/{announcement}", [
            AnnouncementController::class,
            "destroy",
        ])->name("destroy");
        Route::post("/announcements/upload", [
            AnnouncementController::class,
            "uploadImage",
        ])->name("upload");
    },
);

Route::group(["middleware" => ["auth"], "as" => "jobs."], function () {
    Route::post("/jobs", [JobController::class, "store"])->name("store");

    Route::put("/jobs/{job}", [JobController::class, "update"])->name("update");

    Route::put("/jobs/{job}/toggleClosed", [
        JobController::class,
        "toggleClosed",
    ])->name("toggle_closed");

    Route::post("/jobs/upload", [JobController::class, "uploadImage"])->name(
        "upload",
    );
});

Route::group(["middleware" => ["auth"], "as" => "bookings."], function () {
    Route::post("/bookings", [BookingController::class, "store"])->name(
        "store",
    );

    Route::put("/bookings/{booking}", [
        BookingController::class,
        "update",
    ])->name("update");

    Route::delete("/bookings/{booking}", [
        BookingController::class,
        "destroy",
    ])->name("destroy");
});

Route::group(["middleware" => ["auth"], "as" => "comments."], function () {
    Route::post("/comments", [CommentController::class, "store"])->name(
        "store",
    );
    Route::put("/comments/{comment}", [
        CommentController::class,
        "update",
    ])->name("update");
});

Route::delete("/comments/{comment}", [
    CommentController::class,
    "destroy",
])->name("comments.destroy");
Route::delete("/jobs/{job}", [JobController::class, "destroy"])->name(
    "jobs.destroy",
);
require __DIR__ . "/auth.php";
