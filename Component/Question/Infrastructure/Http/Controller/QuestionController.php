<?php

namespace Component\Question\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use Common\Auth\Sdk\AuthFacade;
use Common\Http\ApiResponse;
use Component\Question\Infrastructure\Http\Requests\AddQuestionRequest;
use Component\Question\Infrastructure\Http\Requests\DeleteQuestionRequest;
use Component\Question\Infrastructure\Http\Requests\GetQuestionsRequest;
use Component\Question\Infrastructure\Http\Requests\UpdateQuestionRequest;
use Component\Question\Infrastructure\Http\Resources\QuestionResources;
use Component\Question\Sdk\QuestionFacade;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    private QuestionFacade $questionFacade;
    private AuthFacade $authFacade;

    public function __construct(QuestionFacade $questionFacade, AuthFacade $authFacade)
    {
        $this->questionFacade = $questionFacade;
        $this->authFacade = $authFacade;
    }

    public function getAllQuestions(GetQuestionsRequest $request): JsonResponse
    {
        $questions = $this->questionFacade->getAllQuestions($request);

        $message = 'All questions was loaded successfully';

        return ApiResponse::successResponse(QuestionResources::collection($questions), $message);
    }

    public function addQuestion(AddQuestionRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $questionRead = $this->questionFacade->addQuestion($request, $authUser->getAuthUserId());

        $message = 'Question was added successfully';

        return ApiResponse::successResponse($questionRead->toArray(), $message);
    }

    public function deleteQuestion(DeleteQuestionRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $this->questionFacade->deleteQuestion($request, $authUser->getAuthUserId());

        $message = 'Question was deleted successfully';

        return ApiResponse::successResponse([], $message);
    }

    public function updateQuestion(UpdateQuestionRequest $request): JsonResponse
    {
        $authUser = $this->authFacade->current();
        $questionRead = $this->questionFacade->updateQuestion($request, $authUser->getAuthUserId());

        $message = 'Question was updated successfully';

        return ApiResponse::successResponse($questionRead->toArray(), $message);
    }
}
