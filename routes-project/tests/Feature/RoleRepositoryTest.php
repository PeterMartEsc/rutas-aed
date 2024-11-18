<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Repository\RoleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

use Tests\TestCase;

class RoleRepositoryTest extends TestCase {
    
    private $repository;

    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        $this->repository = new RoleRepository();
        $this->repository->setTestConnection();
        Artisan::call('db:seed', ['--database' => 'sqlite']);
    }

    public function test_001_findAll(): void {
        $list = $this->repository->findAll();
        $this->assertNotNull($list, self::MESSAGE_ERROR);
    }

    public function test_002_findAll_mysqlite(): void {
        $this->repository = new RoleRepository('fakeDb');
        $usersSqlite = $this->repository->findAll();
        $this->assertNotNull($usersSqlite, self::MESSAGE_ERROR);
    }

    public function test_003_save_delete(): void {
        $route = new Role();
        $route->name = 'roleTest';

        $saved = $this->repository->save($route);

        $this->assertEquals($route->id, $saved->id, self::MESSAGE_ERROR);
        $this->assertEquals($route->name, $saved->name, self::MESSAGE_ERROR);

        $deleted = $this->repository->delete($saved);

        $this->assertTrue($deleted, self::MESSAGE_ERROR);
    }

    public function test_004_update(): void {
        $objectToAdd = new Role();
        $objectToAdd->name = 'roleTest';

        $objectDDBB = $this->repository->save($objectToAdd);


        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);

        $objectToUpdate = new Role();
        $objectToUpdate = $objectDDBB;
        $objectToUpdate->name = 'roleUpdate';

        
        $update = $this->repository->update($objectToUpdate);
        $this->assertTrue($update, self::MESSAGE_ERROR);

        $updated = $this->repository->findById($objectToUpdate->id);

        $this->assertEquals($objectDDBB->id, $updated->id, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->name, $updated->name, self::MESSAGE_ERROR);

    }

    public function test_005_find_by_id(): void {
        $objectToAdd = new Role();
        $objectToAdd->name = 'roleTest';


        $saved = $this->repository->save($objectToAdd);

        $find =$this->repository->findById($saved->id);
        $this->assertNotNull($find, self::MESSAGE_ERROR);


        $this->repository = new RoleRepository('fakeDb');
        $find =$this->repository->findById($saved->id);
        $this->assertNotNull($find, self::MESSAGE_ERROR);

    }


    public function test_006_find_by_unique_key(): void {
        $objectToAdd = new Role();
        $objectToAdd->name = 'roleTest';

        $saved = $this->repository->save($objectToAdd);

        $find =$this->repository->findByUniqueKey($saved->name);
        $this->assertNotNull($find, self::MESSAGE_ERROR);

        $this->repository = new RoleRepository('users_sqlite');
        $find =$this->repository->findByUniqueKey($saved->name);
        $this->assertNotNull($find, self::MESSAGE_ERROR);
    }
}
