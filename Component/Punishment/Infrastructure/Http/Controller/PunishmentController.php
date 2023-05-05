<?php

namespace Component\Punishment\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Component\Punishment\Infrastructure\Http\Requests\AddPunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\DeletePunishmentRequest;
use Component\Punishment\Infrastructure\Http\Requests\GetPunishmentsRequest;
use Component\Punishment\Infrastructure\Http\Requests\UpdatePunishmentRequest;
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
        $authUser = $this->authFacade->current();

        $punishmentRead = $this->punishmentFacade->addPunishment($request, $authUser->getAuthUserId());
        $message = 'Punishment was added successfully';

        return ApiResponse::successResponse($punishmentRead->toArray(), $message);
    }

    public function deletePunishment(DeletePunishmentRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $this->punishmentFacade->deletePunishment($request, $authUser->getAuthUserId());

        $message = 'Punishment was deleted successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function updatePunishment(UpdatePunishmentRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $punishmentRead = $this->punishmentFacade->updatePunishment($request, $authUser->getAuthUserId());

        $message = 'Punishment was updated successfully';

        return ApiResponse::successResponse($punishmentRead->toArray(), $message);
    }
}
