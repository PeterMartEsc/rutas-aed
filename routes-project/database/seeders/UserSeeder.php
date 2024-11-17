<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'surname' => 'Administrator',
                'email' => 'admin@example.com',
                'phone' => '+34123456789',
                'password' => Hash::make('1q2w3e4r'),
                'id_role' => 1, 
            ],
            [
                'id' => 2,
                'name' => 'Normal',
                'surname' => 'User',
                'email' => 'user@example.com',
                'phone' => '+3487654321',
                'password' => Hash::make('1q2w3e4r'), 
                'id_role' => 2, 
            ]
        ]);
    }
}
