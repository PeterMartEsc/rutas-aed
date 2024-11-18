<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class RoleRepositoryTest extends TestCase {
    private $repository;

    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        $this->repository = new Role();
        $this->repository->setTestConnection();
    }

    public function test_001_findAll(): void {
        $users = $this->repository->findAll();
        $this->assertNotNull($users, self::MESSAGE_ERROR);
    }

    public function test_002_findAll_mysqlite(): void {
        $this->repository = new UserRepository('users_sqlite');
        $usersSqlite = $this->repository->findAll();
        $this->assertNotNull($usersSqlite, self::MESSAGE_ERROR);
    }

    public function test_003_save_delete(): void {
        $user = new User();
        $user->name = 'nameTest';
        $user->surname = 'surnameTest';
        $user->email = 'test@email.com';
        $user->password = Hash::make('testingPassword');
        $user->phone = '+34123456789';
        $user->id_image = null;
        $user->id_role = 2;

        $savedUser = $this->repository->save($user);

        $this->assertEquals($user->name, $savedUser->name, self::MESSAGE_ERROR);
        $this->assertEquals($user->surname, $savedUser->surname, self::MESSAGE_ERROR);
        $this->assertEquals($user->email, $savedUser->email, self::MESSAGE_ERROR);
        $this->assertEquals($user->phone, $savedUser->phone, self::MESSAGE_ERROR);
        $this->assertEquals($user->id_image, $savedUser->id_image, self::MESSAGE_ERROR);
        $this->assertEquals($user->id_role, $savedUser->id_role, self::MESSAGE_ERROR);

        $this->repository->delete($savedUser);
        $deletedUser = User::find($savedUser->id);
        $this->assertNull($deletedUser, self::MESSAGE_ERROR);
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

        $savedUser = $this->repository->save($user);

        $this->assertNotNull($savedUser, self::MESSAGE_ERROR);

        $userUpdate = new User();
        $userUpdate = $user;
        $userUpdate->name = 'nameTestUpdate';
        $userUpdate->surname = 'surnameTestUpdate';
        $userUpdate->email = 'testUpdate@email.com';
        $userUpdate->password = Hash::make('testingPasswordUpdate');
        $userUpdate->phone = '+34987654321';
        $userUpdate->id_image = 1;
        $userUpdate->id_role = 1;

        $this->repository->update($userUpdate);

        $userUpdated = $this->repository->findById($userUpdate->id);

        $this->assertEquals($userUpdate->id, $userUpdated->id);
        $this->assertEquals($userUpdate->name, $userUpdated->name);
        $this->assertEquals($userUpdate->surname, $userUpdated->surname);
        $this->assertEquals($userUpdate->email, $userUpdated->email);
        $this->assertEquals($userUpdate->phone, $userUpdated->phone);
        $this->assertEquals($userUpdate->id_image, $userUpdated->id_image);
        $this->assertEquals($userUpdate->id_role, $userUpdated->id_role);
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

        $savedUser = $this->repository->save($user);

        $userFind =$this->repository->findById($savedUser->id);
        $this->assertNotNull($userFind, self::MESSAGE_ERROR);


        $this->repository = new UserRepository('users_sqlite');
        $userFind =$this->repository->findById($savedUser->id);
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

        $savedUser = $this->repository->save($user);

        $userFind =$this->repository->findByUniqueKey($savedUser->email);
        $this->assertNotNull($userFind, self::MESSAGE_ERROR);

        $this->repository = new UserRepository('users_sqlite');
        $userFind =$this->repository->findByUniqueKey($savedUser->email);
        $this->assertNotNull($userFind, self::MESSAGE_ERROR);

    }
}
