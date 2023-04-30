<?php

namespace Tests\Unit\Common\Auth\Infrastructure\UserProvider;

use App\Models\User;
use Common\Auth\Domain\UserProvider\UserProvider;
use Common\Auth\Sdk\Model\Authenticate;
use Common\Exception\UnauthorizedException;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @property UserProvider|(UserProvider&\Illuminate\Contracts\Foundation\Application)|\Illuminate\Contracts\Foundation\Application|Application|mixed $userProviderImpl
 */
class UserProviderImplTest extends TestCase
{
    private UserProvider $userProvider;
    private User $user;

    public function test_IsLoggedIn_ShouldReturnFalse_WhenUserIsNotLoggedIn(): void
    {
        $this->assertFalse($this->userProvider->isLoggedIn());
    }

    public function test_IsLoggedIn_ShouldReturnTrue_WhenUserIsLoggedIn(): void
    {
        Auth::login($this->user);

        $this->assertTrue($this->userProvider->isLoggedIn());
    }

    public function test_Current_ShouldThrowUnauthorizedException_WhenUserIsNotLoggedIn(): void
    {
        $this->expectException(UnauthorizedException::class);
        $user = $this->userProvider->current();
    }

    public function test_Current_ShouldReturnAuthenticatedClass_WhenUserIsLoggedIn(): void
    {
        Auth::login($this->user);
        $authenticate = $this->userProvider->current();
        $this->assertInstanceOf(Authenticate::class, $authenticate);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->userProvider = app(UserProvider::class);
    }
}
