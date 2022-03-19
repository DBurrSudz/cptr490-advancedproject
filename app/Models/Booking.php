<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "job_id", "accepted"];

    protected $appends = ["eligible"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function getEligibleAttribute()
    {
        if (
            request()
                ->route()
                ->getName() === "student.jobs.bookings" ||
            request()
                ->route()
                ->getName() === "student.bookings.index"
        ) {
            $job = Job::select("id", "limit")
                ->where("id", $this->job->id)
                ->first();

            $acceptedCount = $job
                ->bookings()
                ->where("accepted", 1)
                ->count();
            if ($acceptedCount === $job->limit && !$this->accepted) {
                return false;
            }
            return true;
        }
        return null;
    }
}
