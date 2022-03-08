<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "date_posted",
        "approved",
        "paid",
        "rate",
        "user_id",
        "admin_id",
    ];

    /**
     * Returns the student that created the job.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the admin that approved the job.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Returns all the comments for the job.
     *
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
