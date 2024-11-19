<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_routes')->insert([
            [
                'user_id' => 1,
                'route_id' => 1,
            ],[
                'user_id' => 1,
                'route_id' => 2,
            ],[
                'user_id' => 1,
                'route_id' => 3,
            ],[
                'user_id' => 1,
                'route_id' => 4,
            ]
        ]);
    }
}
