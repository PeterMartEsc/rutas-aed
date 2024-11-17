<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        Artisan::call('db:seed', ['--class' => 'ImageSeeder']);
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        Artisan::call('db:seed', ['--class' => 'RouteSeeder']);
    }

    public function test_001_findAll(): void {
        $list = Role::all();
        $this->assertNotNull($list, self::MESSAGE_ERROR);
        $this->assertEquals(2, $list->count(), self::MESSAGE_ERROR);
    }

    public function test_002_findById(): void{
        $objectToFind = Role::find(1);
        $this->assertNotNull($objectToFind, self::MESSAGE_ERROR);
        $this->assertEquals(1, $objectToFind->id, self::MESSAGE_ERROR);
        $this->assertEquals('Admin', $objectToFind->name, self::MESSAGE_ERROR);
    }

    public function test_003_save(): void{
        $objectToAdd = new Role();
        $objectToAdd->id = 3;
        $objectToAdd->name = 'RoleTest';
        $objectToAdd->save();

        $objectDDBB = Role::find(3);

        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);
        $this->assertEquals(3, $objectDDBB->id, self::MESSAGE_ERROR);
        $this->assertEquals('RoleTest', $objectDDBB->name, self::MESSAGE_ERROR);
    }

    public function test_004_update(): void{
        $objectToAdd = new Role();
        $objectToAdd->id = 3;
        $objectToAdd->name = 'RoleTest';
        $objectToAdd->save();

        $objectDDBB = Role::find(3);

        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);

        $objectToUpdate = new Role();
        $objectToUpdate = $objectDDBB;
        $objectToUpdate->name = 'RoleTestUpdate';
        $objectToUpdate->save();

        $this->assertEquals(3, $objectToUpdate->id, self::MESSAGE_ERROR);
        $this->assertEquals('RoleTestUpdate', $objectToUpdate->name, self::MESSAGE_ERROR);
    }

    public function test_005_delete(): void{
        $objectToAdd = new Role();
        $objectToAdd->id = 3;
        $objectToAdd->name = 'RoleTest';
        $objectToAdd->save();

        $objectDDBB = Role::find(3);

        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);

        $objectDDBB->delete();
        $list = Role::all();

        $this->assertNull(Role::find(3), self::MESSAGE_ERROR);
        $this->assertEquals(2, $list->count(), self::MESSAGE_ERROR);
    }

    public function test_006_role_has_many_users(): void{
        $role = Role::first();

        $this->assertNotNull($role->users, self::MESSAGE_ERROR);

        $users = $role->users;

        $this->assertTrue($users->count() > 0, self::MESSAGE_ERROR);
    }
}

