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

    /**
     * @var string The guard to use for authenticating this model.
     */
    protected $guard = "admin";

    /**
     * @var array<int,string> The fields of the model that can be bulk inserted and updated.
     */
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
     * @var array<int,string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    /**
     * The attribute to determine if the authenticated user is an admin. This will be used
     * for conditional rendering.
     * @var array<int,string>
     */
    protected $appends = ["is_admin"];

    public const TITLES = ["Mr.", "Mrs.", "Ms.", "Sir.", "Madam."];

    /**
     * Returns true that this model is an admin.
     */
    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    /**
     * Returns all of the announcements that an admin created.
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class)->latest();
    }

    /**
     * Returns of the jobs that an admin approved.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Returns true than an Admin is an admin.
     */
    public function isAdmin()
    {
        return true;
    }
}
