<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemeseterStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semester_student')->insert([
            [
                'semester_id' => '1',
                'student_id' => '1',
            ],
            [
                'semester_id' => '1',
                'student_id' => '3',
            ],
            [
                'semester_id' => '2',
                'student_id' => '4',
            ],
            [
                'semester_id' => '2',
                'student_id' => '6',
            ],
            [
                'semester_id' => '2',
                'student_id' => '7',
            ],
            [
                'semester_id' => '2',
                'student_id' => '9',
            ],
            [
                'semester_id' => '3',
                'student_id' => '2',
            ],
            [
                'semester_id' => '3',
                'student_id' => '3',
            ],
            [
                'semester_id' => '3',
                'student_id' => '8',
            ],
        ]);
    }
}
