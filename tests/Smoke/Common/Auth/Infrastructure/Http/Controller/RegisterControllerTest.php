<?php

namespace Tests\Smoke\Common\Auth\Infrastructure\Http\Controller;

use App\Models\Language;
use Tests\Smoke\SmokeTestCase;

class RegisterControllerTest extends SmokeTestCase
{
    public function test_Registration(): void
    {
        $response = $this->post(route('user.register'), [
            'name' => 'Name',
            'email' => 'example@email.com',
            'username' => 'username',
            'language_id' => Language::first()->getId(),
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
        ]);

        $response->assertStatus(200);
    }
}
