<?php

namespace Database\Factories;
use App\Models\Universite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Universite>
 */
class UniversiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Universite::class;
    public function definition(): array
    {
        return [
            'nom' => $this->faker->name()
        ];
    }
}
