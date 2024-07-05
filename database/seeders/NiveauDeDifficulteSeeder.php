<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NiveauDeDifficulteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = [
            [
                'niveau' => 1,
                'description' => 'Niveau débutant',
            ],
            [
                'niveau' => 2,
                'description' => 'Niveau intermédiaire',
            ],
            [
                'niveau' => 3,
                'description' => 'Niveau avancé',
            ],
        ];
        foreach ($niveaux as $key => $niveau) {
            DB::table('niveau_de_difficultes')->insert($niveau);
        }
    }
}
