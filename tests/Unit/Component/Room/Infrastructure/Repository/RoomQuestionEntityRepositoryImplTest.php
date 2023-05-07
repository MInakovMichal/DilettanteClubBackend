<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Question;
use App\Models\Room;
use App\Models\RoomQuestion;
use App\Models\User;
use Common\Exception\RoomQuestionByIdNotFoundException;
use Component\Room\Infrastructure\Repository\RoomQuestionEntityRepository;
use Tests\TestCase;

class RoomQuestionEntityRepositoryImplTest extends TestCase
{
    private RoomQuestionEntityRepository $repositoryImpl;

    private User $user;

    public function test_AddQuestionsToRoom_ShouldAddNewQuestions_WhenUserAddQuestions(): void
    {
        $question = Question::factory()->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['user_id' => $this->user->getId()]);

        $questionsInRoomBeforeAddNew = RoomQuestion::all();
        $this->assertSame(0, $questionsInRoomBeforeAddNew->count());

        $this->repositoryImpl->addQuestionToRoom($room->getId(), $question->getId());
        $questionsInRoomAfterAddNew = RoomQuestion::all();

        $this->assertSame(1, $questionsInRoomAfterAddNew->count());
    }

    public function test_DeleteQuestionsFromRoom_ShouldDeleteQuestionsFromRoom(): void
    {
        $question = Question::factory()->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['user_id' => $this->user->getId()]);

        RoomQuestion::factory()->create([
            'room_id' => $room->getId(),
            'question_id' => $question->getId()
        ]);

        $questionsInRoomBeforeDelete = RoomQuestion::all();
        $this->assertSame(1, $questionsInRoomBeforeDelete->count());

        $this->repositoryImpl->deleteQuestionFromRoom($room->getId(), $question->getId());
        $questionsInRoomAfterDelete = RoomQuestion::all();

        $this->assertSame(0, $questionsInRoomAfterDelete->count());
    }

    public function test_FindByIdAndRoomIdOrFail_ShouldThrowRoomQuestionByIdNotFoundException_WhenQuestionNotFoundInRoom(): void
    {
        $this->expectException(RoomQuestionByIdNotFoundException::class);

        $roomId = 1;
        $questionId = 1;
        $this->repositoryImpl->findByIdAndRoomIdOrFail($roomId, $questionId);
    }

    public function test_FindByIdAndRoomIdOrFail_ShouldReturnRoomQuestion_WhenQuestionWasFoundInRoom(): void
    {
        $room = Room::factory()->create();
        $question = Question::factory()->create();

        RoomQuestion::factory()->create([
            'room_id' => $room->getId(),
            'question_id' => $question->getId()
        ]);

        $roomQuestion = $this->repositoryImpl->findByIdAndRoomIdOrFail($room->getId(), $question->getId());

        $this->assertInstanceOf(RoomQuestion::class, $roomQuestion);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->repositoryImpl = resolve(RoomQuestionEntityRepository::class);
    }
}
