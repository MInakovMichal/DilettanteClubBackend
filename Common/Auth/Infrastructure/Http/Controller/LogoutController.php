<?php

namespace Common\Auth\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use Common\Auth\Infrastructure\Http\Requests\LoginRequest;
use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Common\Http\BaseRequest;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    private AuthFacade $authFacade;

    public function __construct(AuthFacade $authFacade)
    {
        $this->authFacade = $authFacade;
    }

    public function logout(BaseRequest $request): JsonResponse
    {
        $this->authFacade->logout();

        $message = 'User was logged out successfully';

        return ApiResponse::successResponse([], $message);
    }
}
