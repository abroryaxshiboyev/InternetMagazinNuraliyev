<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_all_users_getting(): void
    {
        $user=User::factory()->create();

        $response = $this->get('/api/users/');

        $response->assertStatus(200);
        $response->assertJson([
            'data'=>true,
        ]);
    }
}
