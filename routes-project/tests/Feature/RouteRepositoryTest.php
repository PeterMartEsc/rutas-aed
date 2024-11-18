<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Route;
use App\Models\User;
use App\Repository\RouteRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class RouteRepositoryTest extends TestCase {
    private $repository;

    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        $this->repository = new RouteRepository();
        $this->repository->setTestConnection();
        Artisan::call('db:seed', ['--database' => 'sqlite']);
    }

    public function test_001_findAll(): void {
        $list = $this->repository->findAll();
        $this->assertNotNull($list, self::MESSAGE_ERROR);

        $this->repository = new RouteRepository('fakeDb');
        $usersSqlite = $this->repository->findAll();
        $this->assertNotNull($usersSqlite, self::MESSAGE_ERROR);
    }

    public function test_002_save(): void {
        $route = new Route();
        $route->title = 'title';
        $route->location = 'location';
        $route->distance = 12;
        $route->date_route =Carbon::now()->format('Y-m-d H:m:s');
        $route->difficulty = 2;
        $route->pets_allowed = true;
        $route->vehicle_needed = false;
        $route->description = 'descriptionTest';
        $route->user_id = 1;

        $saved = $this->repository->save($route);

        $this->assertEquals($route->id, $saved->id, self::MESSAGE_ERROR);
        $this->assertEquals($route->title, $saved->title, self::MESSAGE_ERROR);
        $this->assertEquals($route->location, $saved->location, self::MESSAGE_ERROR);
        $this->assertEquals($route->date_route,$saved->date_route, self::MESSAGE_ERROR);
        $this->assertEquals($route->distance, $saved->distance, self::MESSAGE_ERROR);
        $this->assertEquals($route->description, $saved->description, self::MESSAGE_ERROR);
        $this->assertEquals($route->pets_allowed, $saved->pets_allowed, self::MESSAGE_ERROR);
        $this->assertEquals($route->vehicle_needed, $saved->vehicle_needed, self::MESSAGE_ERROR);
        $this->assertEquals($route->user_id, $saved->user_id, self::MESSAGE_ERROR);

        try {
            $this->repository = new RouteRepository('fakeDb');
            $this->repository->save($route);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }
    }

    public function test_003_delete(): void {
        $route = new Route();
        $route->title = 'title';
        $route->location = 'location';
        $route->distance = 12;
        $route->date_route =Carbon::now()->format('Y-m-d H:m:s');
        $route->difficulty = 2;
        $route->pets_allowed = true;
        $route->vehicle_needed = false;
        $route->description = 'descriptionTest';
        $route->user_id = 1;

        $saved = $this->repository->save($route);

        $this->assertNotNull($saved, self::MESSAGE_ERROR);

        $deleted = $this->repository->delete($saved);
        $this->assertTrue($deleted, self::MESSAGE_ERROR);

        try {
            $this->repository = new RouteRepository('fakeDb');
            $this->repository->delete($saved);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }
    }

    public function test_004_update(): void {
        $objectToAdd = new Route();
        $objectToAdd->title = 'title';
        $objectToAdd->location = 'location';
        $objectToAdd->distance = 12;
        $objectToAdd->date_route = Carbon::now()->format('Y-m-d H:m:s');
        $objectToAdd->difficulty = 2;
        $objectToAdd->pets_allowed = true;
        $objectToAdd->vehicle_needed = false;
        $objectToAdd->description = 'descriptionTest';
        $objectToAdd->user_id = 1;

        $objectDDBB = $this->repository->save($objectToAdd);

        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);

        $objectToUpdate = new Route();
        $objectToUpdate = $objectDDBB;
        $objectToUpdate->title = 'titleUpdate';
        $objectToUpdate->location = 'locationUpdate';
        $objectToUpdate->distance = 5;
        $objectToUpdate->date_route = Carbon::now()->format('Y-m-d H:m:s');
        $objectToUpdate->difficulty = 10;
        $objectToUpdate->pets_allowed = false;
        $objectToUpdate->vehicle_needed = true;
        $objectToUpdate->description = 'descriptionTestUpdate';
        $objectToUpdate->user_id = 2;


        $update = $this->repository->update($objectToUpdate);
        $this->assertTrue($update, self::MESSAGE_ERROR);

        $updated = $this->repository->findById($objectToUpdate->id);
        $this->assertEquals($objectDDBB->id, $updated->id, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->title, $updated->title, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->location, $updated->location, self::MESSAGE_ERROR);
        $this->assertNotNull($updated->date_route, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->distance, $updated->distance, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->description, $updated->description, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->pets_allowed, $updated->pets_allowed, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->vehicle_needed, $updated->vehicle_needed, self::MESSAGE_ERROR);
        $this->assertEquals($objectToUpdate->user_id, $updated->user_id, self::MESSAGE_ERROR);
    
        try {
            $this->repository = new RouteRepository('fakeDb');
            $this->repository->update($objectDDBB);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }
    }

    public function test_005_find_by_id(): void {
        $route = new Route();
        $route->title = 'title';
        $route->location = 'location';
        $route->distance = 12;
        $route->date_route =Carbon::now()->format('Y-m-d H:m:s');
        $route->difficulty = 2;
        $route->pets_allowed = true;
        $route->vehicle_needed = false;
        $route->description = 'descriptionTest';
        $route->user_id = 1;

        $saved = $this->repository->save($route);

        $find =$this->repository->findById($saved->id);
        $this->assertNotNull($find, self::MESSAGE_ERROR);


        $this->repository = new RouteRepository('fakeDb');
        $find =$this->repository->findById($saved->id);
        $this->assertNotNull($find, self::MESSAGE_ERROR);

    }


    public function test_006_find_by_unique_key(): void {
        $route = new Route();
        $route->title = 'title';
        $route->location = 'location';
        $route->distance = 12;
        $route->date_route =Carbon::now()->format('Y-m-d H:m:s');
        $route->difficulty = 2;
        $route->pets_allowed = true;
        $route->vehicle_needed = false;
        $route->description = 'descriptionTest';
        $route->user_id = 1;

        $saved = $this->repository->save($route);

        $find =$this->repository->findByUniqueKey($saved->title);
        $this->assertNotNull($find, self::MESSAGE_ERROR);

        $this->repository = new RouteRepository('fakeDb');
        $find =$this->repository->findByUniqueKey($saved->title);
        $this->assertNotNull($find, self::MESSAGE_ERROR);

    }
}
