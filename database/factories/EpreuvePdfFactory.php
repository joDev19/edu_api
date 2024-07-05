<?php

namespace Database\Factories;

use App\Models\Filiere;
use App\Models\Universite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EpreuvePdf>
 */
class EpreuvePdfFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'universite_id' => Universite::factory(),
            'filiere_id' => Filiere::factory(),
            'path_enoncer' => $this->faker->sentence(),
            'path_corriger' => $this->faker->sentence(),
            'matiere_id' => $this->faker->numberBetween(1, 2),
            'prix' => 5000,
            'classe_id' => 1,
            'session' => $this->faker->words(2, true)
        ];
    }
}
