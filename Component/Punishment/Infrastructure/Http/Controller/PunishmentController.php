<?php

namespace Component\Punishment\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Component\Punishment\Infrastructure\Http\Requests\AddPunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\GetPunishmentsRequest;
use Component\Punishment\Infrastructure\Http\Resources\PunishmentResources;
use Component\Punishment\Sdk\PunishmentFacade;
use Illuminate\Http\JsonResponse;

class PunishmentController extends Controller
{
    private PunishmentFacade $punishmentFacade;
    private AuthFacade $authFacade;

    public function __construct(PunishmentFacade $punishmentFacade, AuthFacade $authFacade)
    {
        $this->punishmentFacade = $punishmentFacade;
        $this->authFacade = $authFacade;
    }

    public function getAllPunishments(GetPunishmentsRequest $request): JsonResponse
    {
        $punishments = $this->punishmentFacade->getAllPunishments($request);

        $message = 'All Punishments was loaded successfully';

        return ApiResponse::successResponse(PunishmentResources::collection($punishments), $message);
    }

    public function addPunishment(AddPunishmentRequest $request): JsonResponse
    {
        $punishmentRead = $this->punishmentFacade->addPunishment($request);
        $message = 'Punishment was added successfully';

        return ApiResponse::successResponse($punishmentRead->toArray(), $message);
    }
}
