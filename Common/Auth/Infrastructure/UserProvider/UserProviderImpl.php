<?php

declare(strict_types=1);

namespace Common\Auth\Infrastructure\UserProvider;

use Common\Auth\Domain\UserProvider\UserProvider;
use Common\Auth\Infrastructure\Mapper\UserProviderMapper;
use Common\Auth\Sdk\Model\Authenticate;
use Common\Exception\UnauthorizedException;
use Component\User\Sdk\UserFacade;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class UserProviderImpl implements UserProvider
{
    private AuthFactory $auth;
    private UserProviderMapper $userProviderMapper;
    private UserFacade $userFacade;

    public function __construct(
        AuthFactory $auth,
        UserProviderMapper $userProviderMapper,
        UserFacade $userFacade
    ) {
        $this->auth = $auth;
        $this->userProviderMapper = $userProviderMapper;
        $this->userFacade = $userFacade;
    }


    /**
     * @return bool
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedMethodCall
     */
    public function isLoggedIn(): bool
    {
        return $this->auth->guard('api')->check();
    }

    /**
     * @return Authenticate
     * @psalm-suppress UndefinedInterfaceMethod
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedMethodCall
     */
    public function current(): Authenticate
    {
        $guard = $this->auth->guard('api');
        /** @var JWTSubject|null $authUser */
        $authUser = $guard->user();
        if ($authUser === null) {
            throw new UnauthorizedException();
        }

        /** @var int $id */
        $id = $authUser->getJWTIdentifier();

        $user = $this->userFacade->findByIdOrFail($id);

        /** @phpstan-ignore-next-line */
        $token = (string) $guard->getToken();

        return $this->userProviderMapper->mapToAuthenticate(
            $token,
            $user,
        );
    }
}
