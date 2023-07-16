<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'name' => 'CSE',
                'email' => 'cse@uiu.com',
                'number' => '14141',
                'total_credit' => '140',
                'department_head' => 'Salekul Islam',
            ],
            [
                'name' => 'BBA',
                'email' => 'bba@uiu.com',
                'number' => '14141',
                'total_credit' => '145',
                'department_head' => 'Rashedul Islam',
            ],
            [
                'name' => 'EEE',
                'email' => 'eee@uiu.com',
                'number' => '14141',
                'total_credit' => '135',
                'department_head' => 'Minarul Islam',
            ],
        ]);
    }
}
