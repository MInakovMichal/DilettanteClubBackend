<?php

namespace Common\Auth\Infrastructure\Service;

use Common\Auth\Domain\UserProvider\UserProvider;
use Common\Auth\Infrastructure\Mapper\UserProviderMapper;
use Common\Auth\Sdk\Contract\LoginContract;
use Common\Auth\Sdk\Contract\RegisterContract;
use Common\Auth\Sdk\Model\Authenticate;
use Common\Exception\UserWithProvidedCredentialsNotFoundException;
use Component\User\Sdk\Model\UserRead;
use Component\User\Sdk\UserFacade;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialiteServiceImpl implements SocialiteService
{
    private UserFacade $userFacade;

    private UserProvider $userProvider;

    private UserProviderMapper $userProviderMapper;

    /**
     * @param UserFacade $userFacade
     * @param UserProviderMapper $userProviderMapper
     * @param UserProvider $userProvider
     */
    public function __construct(UserFacade $userFacade, UserProviderMapper $userProviderMapper, UserProvider $userProvider)
    {
        $this->userFacade = $userFacade;
        $this->userProviderMapper = $userProviderMapper;
        $this->userProvider = $userProvider;
    }


    public function login(LoginContract $contract): Authenticate
    {

        /** @var string $token */
        $token = JWTAuth::attempt(['email' => $contract->getEmail()->getEmailAddress(), 'password' => $contract->getPassword()]);/** @phpstan-ignore-line */

        if (!$token) {
            throw new UserWithProvidedCredentialsNotFoundException();
        }

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
}
