<?php

namespace Tests\Unit\Common\Auth\Domain;

use App\Models\Language;
use App\Models\User;
use Common\Auth\Infrastructure\Http\Requests\LoginRequest;
use Common\Auth\Infrastructure\Http\Requests\RegisterRequest;
use Common\Auth\Sdk\AuthFacade;
use Common\Auth\Sdk\Model\Authenticate;
use Common\Exception\UnauthorizedException;
use Common\Exception\UserWithProvidedCredentialsNotFoundException;
use Component\User\Sdk\Model\UserRead;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthFacadeImplTest extends TestCase
{
    private AuthFacade $authFacade;
    private User $user;

    public function test_IsLoggedIn_ShouldReturnFalse_WhenUserIsNotLoggedIn(): void
    {
        $this->assertFalse($this->authFacade->isLoggedIn());
    }

    public function test_IsLoggedIn_ShouldReturnTrue_WhenUserIsLoggedIn(): void
    {
        Auth::login($this->user);

        $this->assertTrue($this->authFacade->isLoggedIn());
    }

    public function test_Current_ShouldThrowUnauthorizedException_WhenUserIsNotLoggedIn(): void
    {
        $this->expectException(UnauthorizedException::class);
        $user = $this->authFacade->current();
    }

    public function test_Current_ShouldReturnAuthenticatedClass_WhenUserIsLoggedIn(): void
    {
        Auth::login($this->user);
        $authenticate = $this->authFacade->current();
        $this->assertInstanceOf(Authenticate::class, $authenticate);
    }

    public function test_Login_ShouldThrowUserWithProvidedCredentialsNotFoundException_WhenUserNotExists(): void
    {
        $this->expectException(UserWithProvidedCredentialsNotFoundException::class);

        $request = new LoginRequest([
            'email' => 'example@email.com',
            'password' => 'pass_example',
            'device_token' => 'example token'
        ]);

        $this->authFacade->login($request);
    }

    public function test_Login_ShouldReturnAuthenticatedClass_WhenUserIsLoggedIn(): void
    {
        $this->post(route('user.register'), [
            'name' => 'Name',
            'email' => 'example@email.com',
            'username' => 'username',
            'language_id' => Language::first()->getId(),
            'password' => 'Password123#',
            'password_confirmation' => 'Password123#',
        ]);

        $request = new LoginRequest([
            'email' => 'example@email.com',
            'password' => 'Password123#',
            'device_token' => 'example token'
        ]);

        $authenticate = $this->authFacade->login($request);

        $this->assertInstanceOf(Authenticate::class, $authenticate);
    }

    public function test_Register_ShouldReturnUserReadClass_WhenUserIsWasCreated(): void
    {
        $request = new RegisterRequest([
            'name' => fake()->name(),
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'language_id' => Language::firstOrFail()->getId(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password_confirmation' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $userRead = $this->authFacade->register($request);

        $this->assertInstanceOf(UserRead::class, $userRead);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->authFacade = app(AuthFacade::class);
    }
}
