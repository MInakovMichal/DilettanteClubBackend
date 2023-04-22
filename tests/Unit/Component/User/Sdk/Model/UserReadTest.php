<?php

namespace Tests\Unit\Component\User\Sdk\Model;

use Component\User\Sdk\Model\UserRead;
use Tests\TestCase;

class UserReadTest extends TestCase
{
    private UserRead $userReadModel;

    private int $id;

    private string $name;

    private string $username;

    private string $email;

    public function test_GetId_ShouldReturnUserId(): void
    {
        $this->assertSame($this->id, $this->userReadModel->getId());
    }

    public function test_GetName_ShouldReturnUserName(): void
    {
        $this->assertSame($this->name, $this->userReadModel->getName());
    }

    public function test_GetUserName_ShouldReturnUserUsername(): void
    {
        $this->assertSame($this->username, $this->userReadModel->getUsername());
    }

    public function test_GetEmail_ShouldReturnUserEmail(): void
    {
        $this->assertSame($this->email, $this->userReadModel->getEmail());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = 1;
        $this->name = 'name';
        $this->username = 'username';
        $this->email = 'example@email.com';

        $this->userReadModel = new UserRead(
            $this->id,
            $this->name,
            $this->username,
            $this->email
        );
    }
}
