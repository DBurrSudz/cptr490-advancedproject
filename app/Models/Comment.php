<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ["body", "job_id", "user_id"];

    /**
     * Returns the student that created the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the job that the comment belongs to.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
