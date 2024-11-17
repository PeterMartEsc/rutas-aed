<?php

namespace Tests\Feature;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class ImageTest extends TestCase{

        use RefreshDatabase;
    
        protected function setUp(): void{
            parent::setUp();

            Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
            Artisan::call('db:seed', ['--class' => 'ImageSeeder']);
            Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        }
    
        public function test_001_findAll(): void {
            $list = Image::all();
            $this->assertNotNull($list, self::MESSAGE_ERROR);
            $this->assertEquals(2, $list->count(), self::MESSAGE_ERROR);
        }
    
        public function test_002_findById(): void{
            $objectToFind = Image::find(1);
            $this->assertNotNull($objectToFind, self::MESSAGE_ERROR);
            $this->assertEquals(1, $objectToFind->id, self::MESSAGE_ERROR);
            $this->assertEquals('jpg', $objectToFind->type_image, self::MESSAGE_ERROR);

        }
    
        public function test_003_save(): void {
            $image = new Image();
            $imagePathTest = storage_path('images/photoTest2.jpg');
            $image->image = file_get_contents($imagePathTest);
            $image->type_image = 'jpg';
            $image->save();
        
            $savedImage = Image::find($image->id); 

            $this->assertNotNull($savedImage, self::MESSAGE_ERROR);
            $this->assertEquals($image->image, $savedImage->image, self::MESSAGE_ERROR);
            $this->assertEquals('jpg', $savedImage->type_image, self::MESSAGE_ERROR);
            
        }
        
    
        public function test_004_update(): void{
   
    
            $objectToAdd = new Image();
            $imagePathTest = storage_path('images/photoTest2.jpg');
            $objectToAdd->image = file_get_contents($imagePathTest);
            $objectToAdd->type_image = 'jpg';
            $objectToAdd->save();

            $objectDDBB = Image::find(3);
    
            $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);
    
            $objectToUpdate = new Image();
            $objectToUpdate = $objectDDBB;
            $imagePathTest = storage_path('images/photoTest1.jpg');
            $objectToUpdate->image = file_get_contents($imagePathTest);
            $objectToUpdate->type_image = 'jpg';
            $objectToUpdate->save();
    
            $this->assertEquals(3, $objectToUpdate->id, self::MESSAGE_ERROR);
            $this->assertEquals($objectDDBB->image, $objectToUpdate->image, self::MESSAGE_ERROR);
            $this->assertEquals($objectDDBB->type_image, $objectToUpdate->type_image, self::MESSAGE_ERROR);
            
        }
    
        public function test_005_delete(): void{
            $objectToAdd = new Image();
            $imagePathTest = storage_path('images/photoTest2.jpg');
            $objectToAdd->image = file_get_contents($imagePathTest);
            $objectToAdd->type_image = 'jpg';
            $objectToAdd->save();
    
            $objectDDBB = Image::find(3);

            $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);
    
            $objectDDBB->delete();
            $list = Image::all();
    
            $this->assertNull(Image::find(3), self::MESSAGE_ERROR);
            $this->assertEquals(2, $list->count(), self::MESSAGE_ERROR);
        }

        public function test_006_image_has_many_users(): void
        {
            $image = Image::first();
    
            $this->assertNotNull($image->users, self::MESSAGE_ERROR);
    
            $users = $image->users;
    
            $this->assertTrue($users->count() > 0, self::MESSAGE_ERROR);
        }
        
    }
    
    

