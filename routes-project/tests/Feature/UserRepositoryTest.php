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

class UserRepositoryTest extends TestCase
{
    private $userRepository; 
    
    use RefreshDatabase;

    protected function setUp(): void{
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        Artisan::call('db:seed', ['--class' => 'ImageSeeder']);
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        Artisan::call('db:seed', ['--class' => 'RouteSeeder']);
        $this->userRepository = new UserRepository();
    }

    public function test_001_findAll(): void {
        $users = $this->userRepository->findAll();
        $this->assertNotNull($users, self::MESSAGE_ERROR);
    }

    public function test_002_findAll_mysqlite(): void {
        $this->userRepository = new UserRepository('users_sqlite');
        $usersSqlite = $this->userRepository->findAll();
        $this->assertNotNull($usersSqlite, self::MESSAGE_ERROR);
    }

    public function test_003_save(): void {
        $user = new User();
        $user->name = 'nameTest';
        $user->surname = 'surnameTest';
        $user->email = 'test@email.com';
        $user->password = Hash::make('testingPassword');
        $user->phone = '+34123456789';
        $user->id_image = 2;
        $user->id_role = 2;
    
        $savedUser = $this->userRepository->save($user);
    
        $this->assertEquals($user->name, $savedUser->name);
        $this->assertEquals($user->surname, $savedUser->surname);
        $this->assertEquals($user->email, $savedUser->email);
        $this->assertEquals($user->phone, $savedUser->phone);
        $this->assertEquals($user->id_image, $savedUser->id_image);
        $this->assertEquals($user->id_role, $savedUser->id_role);
    }


}
