<?php

namespace Tests\Smoke\Common\Auth\Infrastructure\Http\Controller;

use App\Models\Language;
use Tests\Smoke\SmokeTestCase;

class LoginControllerTest extends SmokeTestCase
{
    public function test_Login(): void
    {
        $this->post(route('user.register'), [
            'name' => 'Name',
            'email' => 'example@email.com',
            'username' => 'username',
            'language_id' => Language::first()->getId(),
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
        ]);
        $response = $this->post(route('user.login'), [
            'email' => 'example@email.com',
            'password' => 'Password123#',
            'device_token' => 'device_token',
        ]);

        $response->assertStatus(200);
    }
}
