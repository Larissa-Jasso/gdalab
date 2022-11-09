<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commune>
 */
class CommuneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $communes = [
            'Gondwana Sanctuary',
            'House of Freedom',
            'Brisbane',
            'ZEGG',
            'Lakabe',
            'Awra Amba',
            'Orania',
            'Kibbutz',
            'Svanholm',
            'Gaviotas',
            'Mazunte',
            'Adelphi',
            'Cohousing',
            'Ecovillage',
        ];

       
        return [
            'region_id' => Region::inRandomOrder()->first()->id,
            'description' => fake()->randomElement($communes),
            'status' => fake()->randomElement(['A', 'I', 'trash']),
        ];
        
    }
}
