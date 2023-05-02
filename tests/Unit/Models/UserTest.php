<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Common\Exception\UserEmailIsNotSetException;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;

    private int $id;

    private string $name;

    private string $username;

    private string $email;

    public function test_GetId_ShouldReturnUserId(): void
    {
        $this->assertSame($this->id, $this->user->getId());
    }

    public function test_GetName_ShouldReturnUserName(): void
    {
        $this->assertSame($this->name, $this->user->getName());
    }

    public function test_GetUsername_ShouldReturnUserUsername(): void
    {
        $this->assertSame($this->username, $this->user->getUserName());
    }

    public function test_IsVerified_ShouldReturnTrue_WhenUserVerifiedEmail(): void
    {
        $this->user->email_verified_at = Carbon::now();
        $this->assertTrue($this->user->isVerified());
    }

    public function test_IsVerified_ShouldReturnFalse_WhenUserNotVerifiedEmail(): void
    {
        $this->user->email_verified_at = null;
        $this->assertFalse($this->user->isVerified());
    }

    public function test_IsBlocked_ShouldReturnFalse_WhenUserIsNotBlocked(): void
    {
        $this->user->is_blocked = false;
        $this->assertFalse($this->user->isBlocked());
    }

    public function test_IsBlocked_ShouldReturnTrue_WhenUserIsBlocked(): void
    {
        $this->user->is_blocked = true;
        $this->assertTrue($this->user->isVerified());
    }

    public function test_GetEmail_ShouldReturnUserEmail(): void
    {
        $this->assertSame($this->email, $this->user->getEmail());
    }

    public function test_GetEmail_ShouldThrowUserEmailIsNotSetException_WhenUserHasNoEmail(): void
    {
        $this->user->email = null;
        $this->expectException(UserEmailIsNotSetException::class);
        $this->user->getEmail();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = 1;
        $this->name = $this->faker->name;
        $this->username = $this->faker->userName;
        $this->email = $this->faker->email;

        $this->user = User::factory()->make([
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
        ]);
    }
}
