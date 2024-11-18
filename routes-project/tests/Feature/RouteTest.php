<?php

namespace Tests\Feature;

use App\Models\Route;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class RouteTest extends TestCase{

    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();

        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        Artisan::call('db:seed', ['--class' => 'ImageSeeder']);
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        Artisan::call('db:seed', ['--class' => 'RouteSeeder']);
    }

    public function test_001_findAll(): void {
        $list = Route::all();
        $this->assertNotNull($list, self::MESSAGE_ERROR);
        $this->assertEquals(4, $list->count(), self::MESSAGE_ERROR);
    }

    public function test_002_findById(): void{
        $savedRoute = Route::find(1);

        $this->assertNotNull($savedRoute, self::MESSAGE_ERROR);

        $this->assertEquals(1, $savedRoute->id, self::MESSAGE_ERROR);
        $this->assertEquals('Mountain Trail', $savedRoute->title, self::MESSAGE_ERROR);
        $this->assertEquals('Mountain Peak, Colorado', $savedRoute->location, self::MESSAGE_ERROR);
        $this->assertNotNull($savedRoute->date_route, self::MESSAGE_ERROR);
        $this->assertEquals(9, $savedRoute->distance, self::MESSAGE_ERROR);
        $this->assertEquals('A challenging trail with a great view from the peak.', $savedRoute->description, self::MESSAGE_ERROR);
        $this->assertEquals(true, $savedRoute->pets_allowed, self::MESSAGE_ERROR);
        $this->assertEquals(true, $savedRoute->vehicle_needed, self::MESSAGE_ERROR);
        $this->assertEquals(1, $savedRoute->user_id, self::MESSAGE_ERROR);
    }

    
    public function test_003_save(): void {
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
        $route->save();
    
        $savedRoute = Route::find(5); 

        $this->assertNotNull($savedRoute, self::MESSAGE_ERROR);

        $this->assertEquals($route->id, $savedRoute->id, self::MESSAGE_ERROR);
        $this->assertEquals($route->title, $savedRoute->title, self::MESSAGE_ERROR);
        $this->assertEquals($route->location, $savedRoute->location, self::MESSAGE_ERROR);
        $this->assertEquals($route->date_route,$savedRoute->date_route, self::MESSAGE_ERROR);
        $this->assertEquals($route->distance, $savedRoute->distance, self::MESSAGE_ERROR);
        $this->assertEquals($route->description, $savedRoute->description, self::MESSAGE_ERROR);
        $this->assertEquals($route->pets_allowed, $savedRoute->pets_allowed, self::MESSAGE_ERROR);
        $this->assertEquals($route->vehicle_needed, $savedRoute->vehicle_needed, self::MESSAGE_ERROR);
        $this->assertEquals($route->user_id, $savedRoute->user_id, self::MESSAGE_ERROR);
    }
    

    
    public function test_004_update(): void{
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
        $objectToAdd->save();

        $objectDDBB = Route::find(5);

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
        $objectToUpdate->save();
        
        $this->assertEquals($objectDDBB->id, $objectToUpdate->id, self::MESSAGE_ERROR);
        $this->assertEquals('titleUpdate', $objectToUpdate->title, self::MESSAGE_ERROR);
        $this->assertEquals('locationUpdate', $objectToUpdate->location, self::MESSAGE_ERROR);
        $this->assertNotNull($objectToUpdate->date_route, self::MESSAGE_ERROR);
        $this->assertEquals(5, $objectToUpdate->distance, self::MESSAGE_ERROR);
        $this->assertEquals('descriptionTestUpdate', $objectToUpdate->description, self::MESSAGE_ERROR);
        $this->assertEquals(false, $objectToUpdate->pets_allowed, self::MESSAGE_ERROR);
        $this->assertEquals(true, $objectToUpdate->vehicle_needed, self::MESSAGE_ERROR);
        $this->assertEquals(2, $objectToUpdate->user_id, self::MESSAGE_ERROR);

    }

    public function test_005_delete(): void{
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
        $objectToAdd->save();


        $objectDDBB = Route::find(5);

        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);

        $objectDDBB->delete();
        $list = Route::all();

        $this->assertNull(Route::find(5), self::MESSAGE_ERROR);
        $this->assertEquals(4, $list->count(), self::MESSAGE_ERROR);
    }
    
    public function test_006_route_belongs_to_user(): void {
        $route = Route::first(); 

        $this->assertNotNull($route->user, self::MESSAGE_ERROR);

        $user = $route->user;

        $this->assertEquals('admin@example.com', $user->email, self::MESSAGE_ERROR);
    }

}



