<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class UserRepositoryTest extends TestCase {
    private $repository;

    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        $this->repository = new UserRepository();
        Artisan::call('db:seed', ['--database' => 'sqlite']);
        $this->repository->setTestConnection();
    }

    public function test_001_findAll(): void {
        $users = $this->repository->findAll();
        $this->assertNotNull($users, self::MESSAGE_ERROR);

        $this->repository = new UserRepository('fakeDb');
        $usersSqlite = $this->repository->findAll();
        $this->assertNotNull($usersSqlite, self::MESSAGE_ERROR);
    }

    public function test_002_save(): void {
        $user = new User();
        $user->name = 'nameTest';
        $user->surname = 'surnameTest';
        $user->email = 'test@email.com';
        $user->password = Hash::make('testingPassword');
        $user->phone = '+34123456789';
        $user->id_image = null;
        $user->id_role = 2;

        $saved = $this->repository->save($user);

        $this->assertEquals($user->name, $saved->name, self::MESSAGE_ERROR);
        $this->assertEquals($user->surname, $saved->surname, self::MESSAGE_ERROR);
        $this->assertEquals($user->email, $saved->email, self::MESSAGE_ERROR);
        $this->assertEquals($user->phone, $saved->phone, self::MESSAGE_ERROR);
        $this->assertEquals($user->id_image, $saved->id_image, self::MESSAGE_ERROR);
        $this->assertEquals($user->id_role, $saved->id_role, self::MESSAGE_ERROR);

        
        try {
            $this->repository = new UserRepository('fakeDb');
            $this->repository->save($user);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }
    }

    public function test_003_delete(): void {
        $user = new User();
        $user->name = 'nameTest';
        $user->surname = 'surnameTest';
        $user->email = 'test@email.com';
        $user->password = Hash::make('testingPassword');
        $user->phone = '+34123456789';
        $user->id_image = null;
        $user->id_role = 2;

        $saved = $this->repository->save($user);
        $this->assertNotNull($saved, self::MESSAGE_ERROR);

        $deleted = $this->repository->delete($saved->id);
        $this->assertTrue($deleted, self::MESSAGE_ERROR);

        try {
            $this->repository = new UserRepository('fakeDb');
            $this->repository->delete($saved->id);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }

    }

    public function test_004_update(): void {
        $user = new User();
        $user->name = 'nameTest';
        $user->surname = 'surnameTest';
        $user->email = 'test@email.com';
        $user->password = Hash::make('testingPassword');
        $user->phone = '+34123456789';
        $user->id_image = null;
        $user->id_role = 2;

        $saved = $this->repository->save($user);
        $this->assertNotNull($saved, self::MESSAGE_ERROR);

        $objectToUpdate = new User();
        $objectToUpdate = $saved;
        $objectToUpdate->name = 'nameTestUpdate';
        $objectToUpdate->surname = 'surnameTestUpdate';
        $objectToUpdate->email = 'testUpdate@email.com';
        $objectToUpdate->password = Hash::make('testingPasswordUpdate');
        $objectToUpdate->phone = '+34987654321';
        $objectToUpdate->id_image = 1;
        $objectToUpdate->id_role = 1;


        $update = $this->repository->update($objectToUpdate);
        $this->assertTrue($update, self::MESSAGE_ERROR);

        $updated = $this->repository->findById($objectToUpdate->id);

        $this->assertEquals($objectToUpdate->id, $updated->id);
        $this->assertEquals($objectToUpdate->name, $updated->name);
        $this->assertEquals($objectToUpdate->surname, $updated->surname);
        $this->assertEquals($objectToUpdate->email, $updated->email);
        $this->assertEquals($objectToUpdate->phone, $updated->phone);
        $this->assertEquals($objectToUpdate->id_image, $updated->id_image);
        $this->assertEquals($objectToUpdate->id_role, $updated->id_role);

        try {
            $this->repository = new UserRepository('fakeDb');
            $this->repository->update($saved);
        } catch (\Exception $e) {
            $this->assertNotNull($e->getMessage());
        }
    }

    public function test_005_find_by_id(): void {
        $user = new User();
        $user->name = 'nameTest';
        $user->surname = 'surnameTest';
        $user->email = 'test@email.com';
        $user->password = Hash::make('testingPassword');
        $user->phone = '+34123456789';
        $user->id_image = null;
        $user->id_role = 2;

        $saved = $this->repository->save($user);

        $userFind =$this->repository->findById($saved->id);
        $this->assertNotNull($userFind, self::MESSAGE_ERROR);

        $this->repository = new UserRepository('fakeDb');
        $userFind =$this->repository->findById($saved->id);
        $this->assertNotNull($userFind, self::MESSAGE_ERROR);

    }


    public function test_006_find_by_unique_key(): void {
        $user = new User();
        $user->name = 'nameTest';
        $user->surname = 'surnameTest';
        $user->email = 'test@email.com';
        $user->password = Hash::make('testingPassword');
        $user->phone = '+34123456789';
        $user->id_image = null;
        $user->id_role = 2;

        $saved = $this->repository->save($user);

        $userFind =$this->repository->findByUniqueKey($saved->email);
        $this->assertNotNull($userFind, self::MESSAGE_ERROR);

        $this->repository = new UserRepository('fakeDb');
        $userFind =$this->repository->findByUniqueKey($saved->email);
        $this->assertNotNull($userFind, self::MESSAGE_ERROR);

    }
}
