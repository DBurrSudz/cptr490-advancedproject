<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "first_name" => "Test",
            "last_name" => "User",
            "email" => "test_user@email.com",
            "ncu_id" => Str::random(8),
            "dob" => now(),
            "description" => "This is a test user account.",
            "password" => Hash::make("password"),
        ]);

        Admin::create([
            "first_name" => "Test",
            "last_name" => "Admin",
            "ncu_id" => Str::random(8),
            "email" => "test_admin@email.com",
            "title" => "Mr.",
            "position" => "Test admin account user.",
            "password" => Hash::make("password"),
        ]);

        Admin::factory()
            ->count(10)
            ->hasAnnouncements(10)
            ->create();

        User::factory()
            ->count(10)
            ->has(
                Job::factory()
                    ->count(10)
                    ->hasComments(10),
            )
            ->create();
    }
}

