<?php

namespace Database\Factories;

use App\Models\EmploymentType;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'           => User::factory(),
            'title'             => $this->faker->text(),
            'employment_type_id'=> EmploymentType::factory(),
            'industry_id'       => Industry::factory(),
            'start_date'        => $this->faker->date(),
            'end_date'          => $this->faker->date(),
            'location'          => $this->faker->city(),
            'description'       => $this->faker->paragraph()
        ];
    }
}
