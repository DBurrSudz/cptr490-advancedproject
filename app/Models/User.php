<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Policies\Contracts\UserInterface;

class User extends Authenticatable implements UserInterface
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "first_name",
        "last_name",
        "ncu_id",
        "address",
        "dob",
        "description",
        "email",
        "password",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    protected $appends = ["is_admin"];

    /**
     * Returns false that this model is an admin.
     */
    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    /**
     * Returns all the jobs that a student has created.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Returns all the comments that a student has created.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Returns false that a student is not an admin.
     */
    public function isAdmin()
    {
        return false;
    }
}
