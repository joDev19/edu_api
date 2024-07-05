<?php

namespace Database\Seeders;

use App\Models\EpreuvePdf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EpreuvePdfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EpreuvePdf::factory()->count(6)->create();
    }
}
