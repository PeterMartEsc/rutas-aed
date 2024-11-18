<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routes')->insert([
            [
                'title' => 'Mountain Trail',
                'location' => 'Mountain Peak, Colorado',
                'distance' => 9,
                'date_route' => Carbon::now()->format('Y-m-d H:m:s'),
                'difficulty' => 8,
                'pets_allowed' => true,
                'vehicle_needed' => true,
                'description' => 'A challenging trail with a great view from the peak.',
                'user_id' => 1, 
            ],
            [
                'title' => 'Beachside Walk',
                'location' => 'Santa Monica Beach, California',
                'distance' => 15, 
                'date_route' =>  Carbon::now()->format('Y-m-d H:m:s'),
                'difficulty' => 2,
                'pets_allowed' => true,
                'vehicle_needed' => false,
                'description' => 'A relaxing walk along the coast with beautiful ocean views.',
                'user_id' => 2,
            ],
            [
                'title' => 'Forest Adventure',
                'location' => 'Redwood National Park, California',
                'distance' => 6, 
                'date_route' => Carbon::now()->format('Y-m-d H:m:s'),
                'difficulty' => 3,
                'pets_allowed' => false,
                'vehicle_needed' => false,
                'description' => 'A quiet hike through the forest with tall redwoods.',
                'user_id' => 1, 
            ],
            [
                'title' => 'Desert Trek',
                'location' => 'Joshua Tree National Park, California',
                'distance' => 3, 
                'date_route' => Carbon::now()->format('Y-m-d H:m:s'),
                'difficulty' => 8,
                'pets_allowed' => false,
                'vehicle_needed' => true,
                'description' => 'A tough trek through the desert landscape. Be prepared.',
                'user_id' => 2, 
            ]
        ]);
    }
}
