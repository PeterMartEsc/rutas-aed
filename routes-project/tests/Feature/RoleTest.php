<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{


    public function test_001_findAll(): void {
        $roles = Role::all();
        
        $this->assertNotNull($roles);
        $this->assertEquals(2, $roles->count());

    }

    public function test_002_findById(): void{

    }

    public function test_003_save(): void{

    }

    public function test_004_update(): void{

    }

    public function test_005_delete(): void{

    }
}

