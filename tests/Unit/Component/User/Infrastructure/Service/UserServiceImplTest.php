<?php

namespace Tests\Unit\Component\User\Infrastructure\Service;

use App\Models\Language;
use App\Models\User;
use Common\Auth\Infrastructure\Http\Requests\RegisterRequest;
use Common\Exception\UserByEmailNotFoundException;
use Common\Exception\UserNotFoundException;
use Common\ValueObject\Email;
use Component\User\Infrastructure\Service\UserService;
use Component\User\Sdk\Model\UserRead;
use Tests\TestCase;
use UnexpectedValueException;

class UserServiceImplTest extends TestCase
{
    private UserService $serviceImpl;

    private User $user;

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

    public function test_FindByIdOrFail_ShouldThrowUserNotFoundException_WhenUserNotFind(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->serviceImpl->findByIdOrFail($this->user->getId() + 1);
    }

    public function test_FindByIdOrFail_ShouldUserReadClass_WhenUserFind(): void
    {
        $userRead = $this->serviceImpl->findByIdOrFail($this->user->getId());

        $this->assertInstanceOf(UserRead::class, $userRead);
    }

    public function test_FindByEmailOrFail_ShouldThrowUserByEmailNotFoundException_WhenUserNotFind(): void
    {
        $this->expectException(UserByEmailNotFoundException::class);
        $email = new Email('wrong_mail@gmail.com');
        $this->serviceImpl->findByEmailOrFail($email);
    }

    public function test_FindByEmailOrFail_ShouldUserReadClass_WhenUserFind(): void
    {
        $email = new Email($this->user->getEmail());
        $userRead = $this->serviceImpl->findByEmailOrFail($email);

        $this->assertInstanceOf(UserRead::class, $userRead);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->name = 'name';
        $this->email = 'example@email.com';
        $this->username = 'username';
        $this->language_id = Language::firstOrFail()->getId();
        $this->password = 'Pass123#';

        $this->user = User::factory()->create([
            'name' => $this->name,
            'email' => 'test@gmail.com',
            'username' => $this->username,
            'actual_language_id' => $this->language_id
        ]);

        $this->serviceImpl = resolve(UserService::class);
    }
}
