<?php

namespace Database\Seeders;

use Faker\Core\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagePath1 = storage_path('images/photoTest1.jpg');
        $imagePath2 = storage_path('images/photoTest2.jpg');


        DB::table('images')->insert([
            [
                'image' => file_get_contents($imagePath1),  
                'type_image' => 'jpg', 
            ],
            [
                'image' => file_get_contents($imagePath2),  
                'type_image' => 'jpg', 
            ],
        ]);
    }
}
