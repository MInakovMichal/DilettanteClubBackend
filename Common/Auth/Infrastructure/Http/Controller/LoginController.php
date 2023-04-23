<?php

namespace Common\Auth\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use Common\Auth\Infrastructure\Http\Requests\LoginRequest;
use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    private AuthFacade $authFacade;

    public function __construct(AuthFacade $authFacade)
    {
        $this->authFacade = $authFacade;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $authenticate = $this->authFacade->authLogin($request);

        $message = 'User was logged in successfully';

        return ApiResponse::successResponse($authenticate->toArray(), $message);
    }
}
