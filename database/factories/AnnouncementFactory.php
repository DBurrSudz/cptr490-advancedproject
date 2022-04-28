<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = $this->faker->randomElement([
            "Scholarship",
            "Internship/Job",
            "General",
            "Other",
        ]);
        return [
            "title" => Str::random(),
            "description" => "<p>" . $this->faker->sentence(300) . "</p>",
            "category" => $category,
        ];
    }
}

