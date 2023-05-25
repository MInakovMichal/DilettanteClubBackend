<?php

namespace Tests\Unit\Common\Auth\Sdk\Model;

use Common\Auth\Sdk\Model\AuthUser;
use Component\User\Sdk\Model\UserRead;
use PHPUnit\Framework\TestCase;

class AuthUserTest extends TestCase
{
    private AuthUser $authUser;
    private int $id;
    private string $name;
    private string $email;
    private int $roomId;
    private bool $inRoom;

    public function test_GetId(): void
    {
        $this->assertSame($this->id, $this->authUser->getId());
    }

    public function test_GetName(): void
    {
        $this->assertSame($this->name, $this->authUser->getName());
    }

    public function test_GetEmail(): void
    {
        $this->assertSame($this->email, $this->authUser->getEmail());
    }

    public function test_GetRoomId(): void
    {
        $this->assertSame($this->roomId, $this->authUser->getRoomId());
    }

    public function test_IsInRoom(): void
    {
        $this->assertTrue($this->authUser->isInRoom());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->id = 1;
        $this->name = 'test_name';
        $this->email = 'test_email';
        $this->roomId = 1;
        $this->inRoom = true;

        $userRead = new UserRead(
            $this->id,
            $this->name,
            'test_username',
            $this->email,
            $this->inRoom
        );

        $userRead->setRoomId($this->roomId);

        $this->authUser = new AuthUser($userRead);
    }

}
