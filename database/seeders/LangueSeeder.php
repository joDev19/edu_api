<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $langues = ['Français', 'Anglais'];
        foreach($langues as $langue){
            DB::table('langues')->insert([
                'name' => $langue
            ]);
        }
    }
}
