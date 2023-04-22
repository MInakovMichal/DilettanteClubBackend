<?php

namespace Tests\Unit\Component\User\Infrastructure\Service;

use App\Models\Language;
use Common\Auth\Infrastructure\Http\Requests\RegisterRequest;
use Component\User\Infrastructure\Service\UserServiceImpl;
use Component\User\Sdk\Model\UserRead;
use Tests\TestCase;
use UnexpectedValueException;

class UserServiceImplTest extends TestCase
{
    private UserServiceImpl $serviceImpl;

    private string $name;

    private string $email;

    private string $username;

    private int $language_id;

    private string $password;

    public function test_CreateUser_ShouldReturnUserReadModel_WhenAllParametersPassed(): void
    {
        $contract = new RegisterRequest([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'language_id' => $this->language_id,
            'password' => $this->password,
        ]);

        $response = $this->serviceImpl->createUser($contract);

        $this->assertInstanceOf(UserRead::class, $response);
    }

    public function test_CreateUser_ShouldThrowUnexpectedValueException_WhenSomethingWrong(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $contract = new RegisterRequest([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'language_id' => $this->language_id,
        ]);

        $this->serviceImpl->createUser($contract);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->name = 'name';
        $this->email = 'example@email.com';
        $this->username = 'username';
        $this->language_id = Language::firstOrFail()->getId();
        $this->password = 'Pass123#';

        $this->serviceImpl = resolve(UserServiceImpl::class);
    }
}
