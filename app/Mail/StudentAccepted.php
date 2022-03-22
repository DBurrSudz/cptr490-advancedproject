<?php

namespace App\Mail;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentAccepted extends Mailable
{
    use Queueable, SerializesModels;

    protected Booking $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->from("jortal@ncu.com", "Jortal NCU")
            ->subject("You have been accepted!")
            ->with([
                "job" => $this->booking->job->title,
                "posted" => Carbon::parse(
                    $this->booking->job->date_posted,
                )->format("d/m/Y"),
            ])
            ->view("mail.student.accepted");
    }
}
