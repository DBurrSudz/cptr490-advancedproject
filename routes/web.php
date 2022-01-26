<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AnnouncementController;
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
        Route::get("/dashboard", [AdminController::class, "dashboard"])->name(
            "dashboard",
        );

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

        // Route::resource(
        //     "manage-announcements",
        //     AnnouncementController::class,
        // )->only(["index", "show"]);
    },
);

//------------------Student Routes------------------------------------------
Route::group(["middleware" => ["auth"], "as" => "student."], function () {
    Route::get("/dashboard", function () {
        return response()->json(["Dashboard" => "Student Dashboard"]);
    })->name("dashboard");

    Route::get("/announcements", [
        AnnouncementController::class,
        "index",
    ])->name("announcements.index");
    Route::get("announcements/{announcement}", [
        AnnouncementController::class,
        "show",
    ])->name("announcements.show");
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
require __DIR__ . "/auth.php";
