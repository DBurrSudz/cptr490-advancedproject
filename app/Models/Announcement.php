<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable = ["title", "category", "description", "admin_id"];

    /**
     * Returns the admin for an announcement.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
