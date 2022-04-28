<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $admin = Admin::inRandomOrder()->first();
        $approved = $this->faker->randomElement([true, false]);
        $paid = $this->faker->randomElement([true, false]);
        $request = $this->faker->randomElement([true, false]);
        return [
            "title" => Str::random(),
            "description" => "<p>" . $this->faker->sentence(300) . "</p>",
            "approved" => $approved,
            "date_posted" => $approved ? $this->faker->dateTime() : null,
            "paid" => $paid,
            "rate" => $paid ? Str::random(6) : null,
            "admin_id" => $approved ? $admin->id : null,
            "request" => $request,
            "closed" => false,
        ];
    }
}

