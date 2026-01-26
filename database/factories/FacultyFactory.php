<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faculty>
 */
class FacultyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_id' => rand(101, 999),
            'name' => $this->faker->name(),
            'position' => 'regular',
            'contact_number' => rand(9000000001, 9999999999),
            'email' => $this->faker->email(),
        ];
    }
}
