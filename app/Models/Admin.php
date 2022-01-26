<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Policies\Contracts\UserInterface;

class Admin extends Authenticatable implements UserInterface
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guard = "admin";
    protected $fillable = [
        "title",
        "ncu_id",
        "first_name",
        "last_name",
        "position",
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

    public function announcements()
    {
        return $this->hasMany(Announcement::class)->latest();
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function isAdmin()
    {
        return true;
    }
}
