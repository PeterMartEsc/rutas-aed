<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Repository\ImageRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

use Tests\TestCase;

class ImageRepositoryTest extends TestCase {
    
    private $repository;

    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        $this->repository = new ImageRepository();
        $this->repository->setTestConnection();
        Artisan::call('db:seed', ['--database' => 'sqlite']);
    }

    public function test_001_findAll(): void {
        $list = $this->repository->findAll();
        $this->assertNotNull($list, self::MESSAGE_ERROR);

        $this->repository = new ImageRepository('fakeDb');
        $usersSqlite = $this->repository->findAll();
        $this->assertNotNull($usersSqlite, self::MESSAGE_ERROR);
    }

    public function test_002_save(): void {
        $image = new Image();
        $imagePathTest = storage_path('images/photoTest2.jpg');
        $image->image = file_get_contents($imagePathTest);
        $image->type_image = 'jpg';
        
        $saved = $this->repository->save($image);

        $this->assertEquals($image->id, $saved->id, self::MESSAGE_ERROR);
        $this->assertEquals($image->image, $saved->image, self::MESSAGE_ERROR);
        $this->assertEquals($image->type_image, $saved->type_image, self::MESSAGE_ERROR);
        
        try {
            $this->repository = new ImageRepository('fakeDb');
            $this->repository->save($image);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }
    }

    public function test_003_delete(): void {
        $image = new Image();
        $imagePathTest = storage_path('images/photoTest2.jpg');
        $image->image = file_get_contents($imagePathTest);
        $image->type_image = 'jpg';
        
        $saved = $this->repository->save($image);
        $this->assertNotNull($saved, self::MESSAGE_ERROR);

        $deleted = $this->repository->delete($saved->id);

        $this->assertTrue($deleted, self::MESSAGE_ERROR);

        try {
            $this->repository = new ImageRepository('fakeDb');
            $this->repository->delete($saved->id);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }
    }

    public function test_004_update(): void {
        $objectToAdd = new Image();
        $imagePathTest = storage_path('images/photoTest2.jpg');
        $objectToAdd->image = file_get_contents($imagePathTest);
        $objectToAdd->type_image = 'jpg';
        

        $objectDDBB = $this->repository->save($objectToAdd);


        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);

        $objectToUpdate = new Image();        
        $objectToUpdate = $objectDDBB;
        $imagePathTestUpdate = storage_path('images/photoTest1.jpg');
        $objectToUpdate->image = file_get_contents($imagePathTestUpdate);
        $objectToUpdate->type_image = 'jpg';

        
        $update = $this->repository->update($objectToUpdate);
        $this->assertTrue($update, self::MESSAGE_ERROR);

        $updated = $this->repository->findById($objectToUpdate->id);

        $this->assertEquals($objectDDBB->id, $updated->id, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->image, $updated->image, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->type_image, $updated->type_image, self::MESSAGE_ERROR);

        try {
            $this->repository = new ImageRepository('fakeDb');
            $this->repository->update($objectDDBB);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }
    }

    public function test_005_find_by_id(): void {
        $objectToAdd = new Image();
        $imagePathTest = storage_path('images/photoTest2.jpg');
        $objectToAdd->image = file_get_contents($imagePathTest);
        $objectToAdd->type_image = 'jpg';
        

        $saved = $this->repository->save($objectToAdd);

        $find =$this->repository->findById($saved->id);
        $this->assertNotNull($find, self::MESSAGE_ERROR);


        $this->repository = new ImageRepository('fakeDb');
        $find =$this->repository->findById($saved->id);
        $this->assertNotNull($find, self::MESSAGE_ERROR);

    }


    public function test_006_find_by_unique_key(): void {
        $objectToAdd = new Image();
        $imagePathTest = storage_path('images/photoTest2.jpg');
        $objectToAdd->image = file_get_contents($imagePathTest);
        $objectToAdd->type_image = 'jpg';
        

        $saved = $this->repository->save($objectToAdd);

        $find =$this->repository->findByUniqueKey($saved->image);
        $this->assertNotNull($find, self::MESSAGE_ERROR);

        $this->repository = new ImageRepository('users_sqlite');
        $find =$this->repository->findByUniqueKey($saved->image);
        $this->assertNotNull($find, self::MESSAGE_ERROR);
    }
}
