<?php

namespace Component\User\Infrastructure\Repository;

use App\Models\User;
use Common\ValueObject\RoleValueObject;
use Component\User\Infrastructure\Mapper\UserEntityMapper;
use Common\Auth\Sdk\Contract\RegisterContract;
use Component\User\Sdk\Model\UserRead;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;
use UnexpectedValueException;

class UserEntityRepositoryImpl implements UserEntityRepository
{
    private UserEntityMapper $mapper;

    public function __construct(UserEntityMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function createUser(RegisterContract $contract): UserRead
    {
        try {
            /** @phpstan-ignore-next-line  */
            $user = User::create([
                'uuid' => Str::uuid(),
                'name' => $contract->getName(),
                'username' => $contract->getUsername(),
                'email' => $contract->getEmail(),
                'password' => Hash::make($contract->getPassword()),
                'actual_language_id' => $contract->getLanguageId(),
                'email_verified_at' => Carbon::now(),
                'is_blocked' => false,
            ]);

            /** @var User $user */
            $user->assignRole(RoleValueObject::USER);

            return $this->mapper->mapToReadModel($user);
        } catch (Throwable $exception) {
            throw new UnexpectedValueException($exception->getMessage());
        }
    }
}
