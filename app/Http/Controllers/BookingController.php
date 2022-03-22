<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Mail\StudentAccepted;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $bookings = $user
            ->bookings()
            ->with("job:id,title")
            ->get();
        return Inertia::render("Bookings/BookingsIndex", [
            "bookings" => $bookings,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        Booking::create($request->validated());
        return back()->withSuccess("Application submitted.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Booking $booking)
    {
        if (!$booking->accepted) {
            $booking->update([
                "accepted" => 1,
                ($message = "Accepted."),
            ]);
            Mail::to($booking->user)->send(new StudentAccepted($booking));
        } else {
            $booking->update([
                "accepted" => 0,
                ($message = "Declined."),
            ]);
        }
        return back()->withSuccess($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->withSuccess("Application removed.");
    }
}
