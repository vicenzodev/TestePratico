<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFeatureTest extends TestCase{
    
    use RefreshDatabase;
    public function testUserCanLogin(){
        $use = User::create([
            'name' => 'Heitor',
            'email' => 'heitor@vicenzo.dev',
            'password' => bcrypt('senhaSegura123'),
            'role' => 'user'
        ]);

        $response = $this->postJson('/api/login',[
            'email' => 'heitor@vicenzo.dev',
            'password' => 'senhaSegura123'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'access_token',
                    'token_type',
                    'user'=> [
                        'id',
                        'name',
                        'email',
                        'role'
                    ]
                 ]);
    }

    public function testUserCannotLogin(){
        User::create([
            'name' => 'Heitor',
            'email' => 'heitor@vicenzo.dev',
            'password' => bcrypt('senhaSegura123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'heitor@vicenzo.dev',
            'password' => 'senhaERRADA'
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Credenciais inválidas']);
    }
}
