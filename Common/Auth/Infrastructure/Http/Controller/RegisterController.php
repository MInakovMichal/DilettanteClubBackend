<?php

namespace Common\Auth\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use Common\Auth\Infrastructure\Http\Requests\RegisterRequest;
use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    private AuthFacade $authFacade;

    public function __construct(AuthFacade $authFacade)
    {
        $this->authFacade = $authFacade;
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        $userRead = $this->authFacade->register($request);

        $message = 'User was created successfully';

        return ApiResponse::successResponse([], $message);
    }
}
