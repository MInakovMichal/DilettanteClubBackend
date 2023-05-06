<?php

namespace Tests\Unit\Common\Auth\Infrastructure\Service;

use App\Models\User;
use Common\Auth\Infrastructure\Http\Requests\LoginRequest;
use Common\Auth\Infrastructure\Service\UserPasswordChecker;
use Common\Exception\UserWithProvidedCredentialsNotFoundException;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserPasswordCheckerImplTest extends TestCase
{
    private UserPasswordChecker $checker;
    private string $password;
    private string $email;

    public function test_Check_ShouldThrowUserWithProvidedCredentialsNotFoundException_WhenUserSendWrongPassword(): void
    {
        $this->expectException(UserWithProvidedCredentialsNotFoundException::class);
        $request = new LoginRequest([
            'password' => $this->password . '_new',
            'email' => $this->email,
            'device_token' => 'example token'
        ]);

        $this->checker->check($request);
    }

    public function test_Check_ShouldReturnString_WhenUserWithEmailAndPasswordIsset(): void
    {
        $request = new LoginRequest([
            'email' => $this->email,
            'password' => $this->password,
            'device_token' => 'example token'
        ]);

        $token = $this->checker->check($request);

        $this->assertIsString($token);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->password = $this->faker->password();
        $this->email = $this->faker->email();

        User::factory()->create([
            'password' => Hash::make($this->password),
            'email' => $this->email
        ]);

        $this->checker = app(UserPasswordChecker::class);
    }
}
