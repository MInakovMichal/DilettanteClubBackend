<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Question;
use App\Models\Room;
use App\Models\RoomQuestion;
use App\Models\User;
use Component\Room\Infrastructure\Repository\RoomQuestionEntityRepository;
use Tests\TestCase;

class RoomQuestionEntityRepositoryImplTest extends TestCase
{
    private RoomQuestionEntityRepository $repositoryImpl;

    private User $user;

    public function test_AddQuestionsToRoom_ShouldAddNewQuestions_WhenUserAddQuestions(): void
    {
        $question = Question::factory()->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['author_id' => $this->user->getId()]);

        $questionsInRoomBeforeAddNew = RoomQuestion::all();
        $this->assertSame(0, $questionsInRoomBeforeAddNew->count());

        $this->repositoryImpl->addQuestionToRoom($room->getId(), $question->getId());
        $questionsInRoomAfterAddNew = RoomQuestion::all();

        $this->assertSame(1, $questionsInRoomAfterAddNew->count());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->repositoryImpl = resolve(RoomQuestionEntityRepository::class);
    }

}
