<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\EmploymentType;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->word(),
            'category_id' => Category::factory(),
            'salary'    => $this->faker->randomFloat(2, 10000, 1000000),
            'employment_type_id' => EmploymentType::factory(),
            'location' => $this->faker->state(),
            'description' => $this->faker->realTextBetween($minNbChars = 160, $maxNbChars = 200, $indexSize = 2),
            'status_id' => Status::factory()
        ];
    }
}
