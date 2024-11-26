<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
class UserTest extends TestCase{

    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();

        Artisan::call('db:seed', ['--database' => 'sqlite']);

    }

    public function test_001_findAll(): void {
        $list = User::all();
        $this->assertNotNull($list, self::MESSAGE_ERROR);
        $this->assertEquals(2, $list->count(), self::MESSAGE_ERROR);
    }

    public function test_002_findById(): void{
        $objectToFind = User::find(1);
        $this->assertNotNull($objectToFind, self::MESSAGE_ERROR);
        $this->assertEquals(1, $objectToFind->id, self::MESSAGE_ERROR);
        $this->assertEquals('Admin', $objectToFind->name, self::MESSAGE_ERROR);
        $this->assertEquals('Administrator', $objectToFind->surname, self::MESSAGE_ERROR);
        $this->assertEquals('admin@example.com', $objectToFind->email, self::MESSAGE_ERROR);
        $this->assertEquals('+34123456789', $objectToFind->phone, self::MESSAGE_ERROR);
        $this->assertTrue(Hash::check('1q2w3e4r', $objectToFind->password), self::MESSAGE_ERROR);
        $this->assertEquals(1, $objectToFind->id_role, self::MESSAGE_ERROR);
    }

    public function test_003_save(): void {
        $user = new User();
        $user->name = 'nameTest';
        $user->surname = 'surnameTest';
        $user->email = 'test@email.com';
        $user->password = Hash::make('testingPassword');
        $user->phone = '+34123456789';
        $user->id_role = 2;
        $user->save();
    
        $savedUser = User::find($user->id); 

        $this->assertNotNull($savedUser, self::MESSAGE_ERROR);
        $this->assertEquals('nameTest', $savedUser->name, self::MESSAGE_ERROR);
        $this->assertEquals('surnameTest', $savedUser->surname, self::MESSAGE_ERROR);
        $this->assertEquals('test@email.com', $savedUser->email, self::MESSAGE_ERROR);
        $this->assertTrue(Hash::check('testingPassword', $savedUser->password), self::MESSAGE_ERROR);
        $this->assertEquals('+34123456789', $savedUser->phone, self::MESSAGE_ERROR);
        $this->assertEquals(2, $savedUser->id_role, self::MESSAGE_ERROR);
    }
    

    public function test_004_update(): void{
        $objectToAdd = new User();
        $objectToAdd->name = 'nameTest';
        $objectToAdd->surname = 'surnameTest';
        $objectToAdd->email = 'test@email.com';
        $objectToAdd->password = Hash::make('testingPassword');
        $objectToAdd->phone = '+34123456789';
        $objectToAdd->id_role = 2;
        $objectToAdd->save();

        $objectDDBB = User::find(3);

        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);

        $objectToUpdate = new User();
        $objectToUpdate = $objectDDBB;
        $objectToUpdate->name = 'nameTestUpdate';
        $objectToUpdate->surname = 'surnameTestUpdate';
        $objectToUpdate->email = 'testUpdate@email.com';
        $objectToUpdate->password = Hash::make('testingPasswordUpdate');
        $objectToUpdate->phone = '+3412345689';
        $objectToUpdate->id_role=1;
        $objectToUpdate->save();

        $this->assertEquals(3, $objectToUpdate->id, self::MESSAGE_ERROR);
        $this->assertEquals('nameTestUpdate', $objectToUpdate->name, self::MESSAGE_ERROR);
        $this->assertEquals('surnameTestUpdate', $objectToUpdate->surname, self::MESSAGE_ERROR);
        $this->assertEquals('testUpdate@email.com', $objectToUpdate->email, self::MESSAGE_ERROR);
        $this->assertTrue(Hash::check('testingPasswordUpdate', $objectToUpdate->password), self::MESSAGE_ERROR);
        $this->assertEquals('+3412345689', $objectToUpdate->phone, self::MESSAGE_ERROR);
        $this->assertEquals(1, $objectToUpdate->id_role, self::MESSAGE_ERROR);
    }

    public function test_005_delete(): void{
        $objectToAdd = new User();
        $objectToAdd->name = 'nameTest';
        $objectToAdd->surname = 'surnameTest';
        $objectToAdd->email = 'test@email.com';
        $objectToAdd->password = Hash::make('testingPassword');
        $objectToAdd->phone = '+34123456789';
        $objectToAdd->id_role = 2;
        $objectToAdd->save();


        $objectDDBB = User::find(3);

        $this->assertNotNull($objectDDBB, self::MESSAGE_ERROR);

        $objectDDBB->delete();
        $list = User::all();

        $this->assertNull(User::find(3), self::MESSAGE_ERROR);
        $this->assertEquals(2, $list->count(), self::MESSAGE_ERROR);
    }

        
    public function test_006_user_has_many_routes(): void{
        $user = User::first(); 

        $this->assertNotNull($user->routes, self::MESSAGE_ERROR);

        $routes = $user->routes;

        $this->assertTrue($routes->count() > 0, self::MESSAGE_ERROR);
    }


    public function test_007_user_belongs_to_role(): void
    {
        $user = User::first(); 

        $this->assertNotNull($user->role, self::MESSAGE_ERROR);

        $role = $user->role;
        $this->assertEquals('Admin', $role->name, self::MESSAGE_ERROR);
    }

}

