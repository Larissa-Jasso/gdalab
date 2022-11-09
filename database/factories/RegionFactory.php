<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $regions = [
            'América',
            'Asia-Pacífico',
            'Europa',
            'Oriente',
        ];

        return [
            'description' => fake()->randomElement($regions),
            'status' => fake()->randomElement(['A', 'I', 'trash']),
        ];
    }
}
