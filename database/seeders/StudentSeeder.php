<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'name' => 'ashik',
                'email' => 'ashik@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '14141',
                'department_id' => rand(1, 3),
                'guardian_number' => '14141',
            ],
            [
                'name' => 'anik',
                'email' => 'anik@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '14141',
                'department_id' => rand(1, 3),
                'guardian_number' => '14141',
            ],
            [
                'name' => 'imran',
                'email' => 'imran@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '879789',
                'department_id' => rand(1, 3),
                'guardian_number' => '80',
            ],
            [
                'name' => 'shomik',
                'email' => 'shomik@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '14149961',
                'department_id' => rand(1, 3),
                'guardian_number' => '779',
            ],
            [
                'name' => 'shourov',
                'email' => 'shourov@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '14141',
                'department_id' => rand(1, 3),
                'guardian_number' => '14141',
            ],
            [
                'name' => 'rohit',
                'email' => 'rohit@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '124146',
                'department_id' => rand(1, 3),
                'guardian_number' => '41',
            ],
            [
                'name' => 'ahmed',
                'email' => 'ahmed@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '124146',
                'department_id' => rand(1, 3),
                'guardian_number' => '41',
            ],
            [
                'name' => 'gurbaz',
                'email' => 'gurbaz@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '124146',
                'department_id' => rand(1, 3),
                'guardian_number' => '41',
            ],
            [
                'name' => 'tareq',
                'email' => 'tareq@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '124146',
                'department_id' => rand(1, 3),
                'guardian_number' => '41',
            ],
            [
                'name' => 'papon',
                'email' => 'papon@uiu.com',
                'password' => Hash::make('123456'),
                'number' => '4124145',
                'department_id' => rand(1, 3),
                'guardian_number' => '41',
            ],
        ]);
    }
}
