<?php

namespace Tests\Smoke\Common\Auth\Infrastructure\Http\Controller;

use App\Models\Language;
use App\Models\User;
use Tests\Smoke\SmokeTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutControllerTest extends SmokeTestCase
{
    public function test_Login(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->post('api/auth/logout?token=' . $token);
        $response->assertStatus(200);
    }
}
