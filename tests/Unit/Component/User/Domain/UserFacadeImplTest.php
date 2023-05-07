<?php

namespace Tests\Unit\Component\User\Domain;

use App\Models\Language;
use App\Models\Room;
use App\Models\User;
use Common\Auth\Infrastructure\Http\Requests\RegisterRequest;
use Common\Exception\UserByEmailNotFoundException;
use Common\Exception\UserNotFoundException;
use Common\ValueObject\Email;
use Component\User\Sdk\Model\UserRead;
use Component\User\Sdk\UserFacade;
use Tests\TestCase;
use UnexpectedValueException;

class UserFacadeImplTest extends TestCase
{
    private UserFacade $facadeImpl;

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

        $response = $this->facadeImpl->createUser($contract);

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

        $this->facadeImpl->createUser($contract);
    }

    public function test_FindByIdOrFail_ShouldThrowUserNotFoundException_WhenUserNotFind(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->facadeImpl->findByIdOrFail($this->user->getId() + 1);
    }

    public function test_FindByIdOrFail_ShouldUserReadClass_WhenUserFind(): void
    {
        $userRead = $this->facadeImpl->findByIdOrFail($this->user->getId());

        $this->assertInstanceOf(UserRead::class, $userRead);
    }

    public function test_FindByEmailOrFail_ShouldThrowUserByEmailNotFoundException_WhenUserNotFind(): void
    {
        $this->expectException(UserByEmailNotFoundException::class);
        $email = new Email('wrong_mail@gmail.com');
        $this->facadeImpl->findByEmailOrFail($email);
    }

    public function test_FindByEmailOrFail_ShouldUserReadClass_WhenUserFind(): void
    {
        $email = new Email($this->user->getEmail());
        $userRead = $this->facadeImpl->findByEmailOrFail($email);

        $this->assertInstanceOf(UserRead::class, $userRead);
    }

    public function test_AddRoomToUser_ShouldUpdateUser(): void
    {
        $room = Room::factory()->create();

        $this->facadeImpl->addRoomToUser($this->user->getId(), $room->getId());

        $user = User::find($this->user->getId());

        $this->assertNotNull($user->getRoomId());
    }

    public function test_DeleteRoomFromUser_ShouldUpdateUser(): void
    {
        $room = Room::factory()->create();
        $this->user->setRoomId($room->getId());
        $this->user->save();

        $this->facadeImpl->deleteRoomFromUser($this->user->getId());

        $user = User::find($this->user->getId());

        $this->assertFalse($user->inRoom());
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

        $this->facadeImpl = resolve(UserFacade::class);
    }
}
