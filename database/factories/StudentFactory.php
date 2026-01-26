<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_number' => rand(1000000, 9999999).'-'.rand(1, 2),
            'name' => $this->faker->name(),
            'year_level' => rand(1, 4),
            'section' => Str::random(1),
            'contact_number' => rand(9000000001, 9999999999),
            'email' => $this->faker->email(),
        ];
    }
}
