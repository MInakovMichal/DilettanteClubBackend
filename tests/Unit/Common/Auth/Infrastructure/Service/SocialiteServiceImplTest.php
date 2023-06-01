<?php

namespace Tests\Unit\Common\Auth\Infrastructure\Service;

use App\Models\Language;
use App\Models\User;
use Common\Auth\Infrastructure\Http\Requests\LoginRequest;
use Common\Auth\Infrastructure\Http\Requests\RegisterRequest;
use Common\Auth\Infrastructure\Service\SocialiteService;
use Common\Auth\Sdk\Model\Authenticate;
use Common\Exception\UnauthorizedException;
use Common\Exception\UserWithProvidedCredentialsNotFoundException;
use Component\User\Sdk\Model\UserRead;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialiteServiceImplTest extends TestCase
{
    private SocialiteService $socialiteService;
    private User $user;

    public function test_IsLoggedIn_ShouldReturnFalse_WhenUserIsNotLoggedIn(): void
    {
        $this->assertFalse($this->socialiteService->isLoggedIn());
    }

    public function test_IsLoggedIn_ShouldReturnTrue_WhenUserIsLoggedIn(): void
    {
        Auth::login($this->user);

        $this->assertTrue($this->socialiteService->isLoggedIn());
    }

    public function test_Current_ShouldThrowUnauthorizedException_WhenUserIsNotLoggedIn(): void
    {
        $this->expectException(UnauthorizedException::class);
        $user = $this->socialiteService->current();
    }

    public function test_Current_ShouldReturnAuthenticatedClass_WhenUserIsLoggedIn(): void
    {
        Auth::login($this->user);
        $authenticate = $this->socialiteService->current();
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

        $this->socialiteService->login($request);
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

        $authenticate = $this->socialiteService->login($request);

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

        $userRead = $this->socialiteService->register($request);

        $this->assertInstanceOf(UserRead::class, $userRead);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->socialiteService = app(SocialiteService::class);
    }
}
