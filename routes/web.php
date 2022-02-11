<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AnnouncementController;
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

// Route::get("/", function () {
//     return Inertia::render("Welcome", [
//         "canLogin" => Route::has("login"),
//         "canRegister" => Route::has("register"),
//         "laravelVersion" => Application::VERSION,
//         "phpVersion" => PHP_VERSION,
//     ]);
// });

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

        Route::get("manage-announcements/{announcement}", [
            AnnouncementController::class,
            "show",
        ])->name("announcements.show");

        Route::get("manage-announcements/{announcement}/edit", [
            AnnouncementController::class,
            "edit",
        ])->name("announcements.edit");

        Route::get("manage-announcements/create", [
            AnnouncementController::class,
            "create",
        ])->name("announcements.create");

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
    },
);

Route::group(["middleware" => ["auth"], "as" => "jobs."], function () {
    Route::post("/jobs", [JobController::class, "store"])->name("store");

    Route::put("/jobs/{job}", [JobController::class, "update"])->name("update");
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
