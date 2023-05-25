<?php

namespace Tests\Unit\Common\Auth\Sdk\Model;

use Common\Auth\Sdk\Model\Authenticate;
use Common\Auth\Sdk\Model\AuthUser;
use Component\User\Sdk\Model\UserRead;
use PHPUnit\Framework\TestCase;

class AuthenticateTest extends TestCase
{
    private Authenticate $authenticate;
    private string $token;
    private AuthUser $authUser;
    private int $authUserId;
    private string $name;
    private string $email;
    private bool $inRoom;
    private int $roomId;

    public function test_GetToken(): void
    {
        $this->assertSame($this->token, $this->authenticate->getToken());
    }

    public function test_GetAuthUser(): void
    {
        $this->assertEquals($this->authUser, $this->authenticate->getAuthUser());
    }

    public function test_GetAuthUserId(): void
    {
        $this->assertEquals($this->authUserId, $this->authenticate->getAuthUserId());
    }

    public function test_ToArray(): void
    {
        $expectArray = [
            'id' => $this->authUserId,
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token,
            'in_room' => $this->inRoom
        ];
        $this->assertEquals($expectArray, $this->authenticate->toArray());
    }

    public function test_GetRoomId(): void
    {
        $this->assertSame($this->roomId, $this->authenticate->getRoomId());
    }

    public function test_IsInRoom(): void
    {
        $this->assertTrue($this->authenticate->isInRoom());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->authUserId = 1;
        $this->name = 'test_name';
        $this->email = 'test_email';
        $this->inRoom = true;
        $this->roomId = 1;

        $userRead = new UserRead(
            $this->authUserId,
            $this->name,
            'test_username',
            $this->email,
            $this->inRoom
        );

        $userRead->setRoomId($this->roomId);
        $this->token = 'test_token';
        $this->authUser = new AuthUser($userRead);

        $this->authenticate = new Authenticate($this->token, $this->authUser);
    }

}
