<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle(),
            'date' => now()->addDay(),
            'time_start' => now()->addDay()->format('H:s.u'),
            'time_end' => now()->addDay()->addHours(2)->format('H:s.u'),
            'description' => $this->faker->paragraph(2),
        ];
    }
}
