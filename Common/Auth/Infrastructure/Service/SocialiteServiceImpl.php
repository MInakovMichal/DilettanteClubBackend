<?php

namespace Common\Auth\Infrastructure\Service;

use Common\Auth\Domain\UserProvider\UserProvider;
use Common\Auth\Infrastructure\Mapper\UserProviderMapper;
use Common\Auth\Sdk\Contract\LoginContract;
use Common\Auth\Sdk\Contract\RegisterContract;
use Common\Auth\Sdk\Model\Authenticate;
use Component\User\Sdk\Model\UserRead;
use Component\User\Sdk\UserFacade;

class SocialiteServiceImpl implements SocialiteService
{
    private UserFacade $userFacade;

    private UserProvider $userProvider;

    private UserProviderMapper $userProviderMapper;

    private UserPasswordChecker $checker;

    /**
     * @param UserFacade $userFacade
     * @param UserProviderMapper $userProviderMapper
     * @param UserProvider $userProvider
     * @param UserPasswordChecker $checker
     */
    public function __construct(
        UserFacade $userFacade,
        UserProviderMapper $userProviderMapper,
        UserProvider $userProvider,
        UserPasswordChecker $checker
    ) {
        $this->userFacade = $userFacade;
        $this->userProviderMapper = $userProviderMapper;
        $this->userProvider = $userProvider;
        $this->checker = $checker;
    }


    public function login(LoginContract $contract): Authenticate
    {
        $token = $this->checker->check($contract);

        $user = $this->userFacade->findByEmailOrFail($contract->getEmail());

        return $this->userProviderMapper->mapToAuthenticate($token, $user);
    }

    public function isLoggedIn(): bool
    {
        return $this->userProvider->isLoggedIn();
    }

    public function current(): Authenticate
    {
        return $this->userProvider->current();
    }

    public function register(RegisterContract $contract): UserRead
    {
        return $this->userFacade->createUser($contract);
    }

    public function logout(): void
    {
        /** @phpstan-ignore-next-line */
        auth()->logout();
    }
}
