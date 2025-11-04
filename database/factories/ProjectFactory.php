<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [
        'title' => $this->faker->sentence(3),
        'icon' => 'fas fa-laptop-code',
        'description' => $this->faker->paragraph(),
        'technologies' => json_encode($this->faker->randomElements(
            ['Laravel', 'Vue.js', 'React', 'Tailwind', 'MySQL', 'Node.js'],
            rand(3, 5)
        )),
        'demo_link' => $this->faker->url(),
        'source_code' => $this->faker->url(),
    ];
}

}
