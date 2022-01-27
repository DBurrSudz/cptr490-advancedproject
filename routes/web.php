<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\JobController;
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
        //Dashboard
        Route::get("/dashboard", [AdminController::class, "dashboard"])->name(
            "dashboard",
        );

        //Announcements
        Route::get("manage-announcements", [
            AnnouncementController::class,
            "index",
        ])->name("manage-announcements.index");

        Route::get("manage-announcements/{announcement}", [
            AnnouncementController::class,
            "show",
        ])->name("manage-announcements.show");

        Route::get("manage-announcements/{announcement}/edit", [
            AnnouncementController::class,
            "edit",
        ])->name("manage-announcements.edit");

        //Jobs
        Route::get("manage-jobs", [JobController::class, "index"])->name(
            "manage-jobs.index",
        );

        Route::get("manage-jobs/{job}", [JobController::class, "show"])->name(
            "manage-jobs.show",
        );

        Route::put("manage-jobs/status/{job}", [
            JobController::class,
            "approveAndDisapproveJob",
        ])->name("manage-jobs.status");
    },
);

//------------------Student Routes------------------------------------------
Route::group(["middleware" => ["auth"], "as" => "student."], function () {
    //Dashboard
    Route::get("/dashboard", function () {
        return response()->json(["Dashboard" => "Student Dashboard"]);
    })->name("dashboard");

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
    Route::get("jobs", [JobController::class, "index"])->name("index");
    Route::get("jobs/{job}", [JobController::class, "show"])->name("show");
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

Route::delete("/jobs/{job}", [JobController::class, "destroy"])->name(
    "destroy",
);
require __DIR__ . "/auth.php";
