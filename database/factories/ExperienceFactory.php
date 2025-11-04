<?php

namespace Database\Factories;

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
public function definition(): array
{
    return [
        'title' => $this->faker->jobTitle(),
        'company' => $this->faker->company(),
        'period' => $this->faker->date('M Y') . ' - Sekarang',
        'description' => $this->faker->paragraph(),
        'details' => json_encode($this->faker->sentences(3)),
    ];
}

}
