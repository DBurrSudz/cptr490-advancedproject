<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard("admin")->check()) {
            $announcements = Announcement::select([
                "id",
                "title",
                "category",
                "admin_id",
                "created_at",
            ])
                ->latest()
                ->with("admin:id,first_name,last_name")
                ->get();
        } else {
            $announcements = Announcement::select([
                "id",
                "title",
                "category",
                "created_at",
            ])
                ->latest()
                ->get();
        }
        return Inertia::render("Announcements/AnnouncementIndex", [
            "announcements" => $announcements,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("manageAnnouncements", Announcement::class);
        return Inertia::render("Announcements/CreateEdit", [
            "mode" => "create",
            "categories" => Announcement::CATEGORIES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        $this->authorize("manageAnnouncements", Announcement::class);
        Announcement::create($request->validated());
        return back()->withSuccess("Announcement created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        return Inertia::render("Announcements/ViewAnnouncement", [
            "announcement" => $announcement,
            "admin" => $announcement->admin,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        $this->authorize("manageAnnouncements", Announcement::class);
        return Inertia::render("Announcements/CreateEdit", [
            "announcement" => $announcement,
            "mode" => "edit",
            "categories" => Announcement::CATEGORIES,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(
        AnnouncementRequest $request,
        Announcement $announcement
    ) {
        $this->authorize("manageAnnouncements", Announcement::class);
        $validatedRequest = $request->validated();
        $announcement->update([
            "title" => $validatedRequest["title"],
            "description" => $validatedRequest["description"],
            "category" => $validatedRequest["category"],
        ]);

        return back()->withSuccess("Announcement updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $this->authorize("manageAnnouncements", Announcement::class);
        $announcement->delete();
        return back()->withSuccess("Announcement removed!");
    }

    public function myAnnouncements(Request $request)
    {
        return Inertia::render("Announcements/AdminAnnouncements", [
            "announcements" => $request->user("admin")->announcements,
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
