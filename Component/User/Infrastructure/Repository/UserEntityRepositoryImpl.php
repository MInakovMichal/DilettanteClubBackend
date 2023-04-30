<?php

namespace Component\User\Infrastructure\Repository;

use App\Models\User;
use Common\Auth\Sdk\Contract\RegisterContract;
use Common\Exception\UserNotFoundException;
use Common\ValueObject\Email;
use Common\ValueObject\RoleValueObject;
use Component\User\Sdk\Exception\UserByEmailNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Throwable;
use UnexpectedValueException;

class UserEntityRepositoryImpl implements UserEntityRepository
{
    private User $entity;

    public function __construct(User $entity)
    {
        $this->entity = $entity;
    }

    public function createUser(RegisterContract $contract): User
    {
        try {
            /** @phpstan-ignore-next-line */
            $user = $this->entity::create([
                'name' => $contract->getName(),
                'username' => $contract->getUsername(),
                'email' => $contract->getEmail()->getEmailAddress(),
                'password' => Hash::make($contract->getPassword()),
                'actual_language_id' => $contract->getLanguageId(),
                'email_verified_at' => Carbon::now(),
                'is_blocked' => false,
            ]);

            /** @var User $user */
            $user->assignRole(RoleValueObject::USER);

            return $user;
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }

    public function findByEmailOrFail(Email $email): User
    {
        try {
            /** @var User $user */
            $user = $this->entity::where('email', $email->getEmailAddress())->firstOrFail();

            return $user;
        } catch (ModelNotFoundException $exception) {
            throw new UserByEmailNotFoundException($email->getEmailAddress());
        }
    }

    public function findByIdOrFail(int $id): User
    {
        try {
            /** @var User $user */
            $user = $this->entity->findOrFail($id);
            return $user;
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException($id);
        }
    }
}
