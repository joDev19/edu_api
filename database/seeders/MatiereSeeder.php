<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matieres = [
            [
                'name' => 'Anglais',
                'description' => 'Anglais pour tous',
            ],
            [
                'name' => 'Mathématique',
                'description' => 'Mathématique pour tous',
            ],
        ];
        foreach ($matieres as $key => $matiere) {
            DB::table('matieres')->insert($matiere);
        }
    }
}
