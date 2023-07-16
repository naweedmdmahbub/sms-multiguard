<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemeseterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semesters')->insert([
            [
                'name' => '2023-sem-1',
                'year' => '2023',
            ],
            [
                'name' => '2023-sem-2',
                'year' => '2023',
            ],
            [
                'name' => '2023-sem-3',
                'year' => '2023',
            ],
        ]);
    }
}
