<?php

namespace Tests\Unit\Component\Room\Infrastructure\Service;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\Question;
use App\Models\Room;
use App\Models\RoomPunishment;
use App\Models\RoomQuestion;
use App\Models\RoomUser;
use App\Models\User;
use Common\Exception\RoomByIdNotFoundException;
use Component\Room\Infrastructure\Http\Requests\AddPunishmentsToRoomRequest;
use Component\Room\Infrastructure\Http\Requests\AddQuestionsToRoomRequest;
use Component\Room\Infrastructure\Http\Requests\CreateRoomRequest;
use Component\Room\Infrastructure\Http\Requests\DeletePunishmentsFromRoomRequest;
use Component\Room\Infrastructure\Http\Requests\DeleteQuestionsFromRoomRequest;
use Component\Room\Infrastructure\Http\Requests\UserEnterRoomRequest;
use Component\Room\Infrastructure\Http\Requests\UserLeaveRoomRequest;
use Component\Room\Infrastructure\Service\RoomService;
use Component\Room\Sdk\Model\RoomRead;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoomServiceImplTest extends TestCase
{
    private RoomService $serviceImpl;

    private User $user;

    public function test_CreateRoom_ShouldReturnRoomReadClass_WhenUserCreateRoom(): void
    {
        $roomValue = $this->faker->sentence();
        $language = Language::firstOrFail();

        $contract = new CreateRoomRequest([
            'name' => $roomValue,
            'is_private' => false,
            'language_id' => $language->getId()
        ]);

        $roomRead = $this->serviceImpl->createRoom($contract, $this->user->getId());

        $this->assertInstanceOf(RoomRead::class, $roomRead);
    }

    public function test_AddQuestionsToRoom_ShouldAddNewQuestions_WhenUserAddQuestions(): void
    {
        $questionsCount = 10;
        $questions = Question::factory($questionsCount)->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['user_id' => $this->user->getId()]);

        $contract = new AddQuestionsToRoomRequest([
            'questions' => $questions->pluck('id')->toArray(),
            'room_id' => $room->getId()
        ]);

        $questionsInRoomBeforeAddNew = RoomQuestion::all();
        $this->assertSame(0, $questionsInRoomBeforeAddNew->count());

        $this->serviceImpl->addQuestionsToRoom($contract);
        $questionsInRoomAfterAddNew = RoomQuestion::all();

        $this->assertSame($questionsCount, $questionsInRoomAfterAddNew->count());
    }

    public function test_AddPunishmentsToRoom_ShouldAddNewPunishments_WhenUserAddPunishments(): void
    {
        $punishmentsCount = 10;
        $punishments = Punishment::factory($punishmentsCount)->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['user_id' => $this->user->getId()]);

        $contract = new AddPunishmentsToRoomRequest([
            'punishments' => $punishments->pluck('id')->toArray(),
            'room_id' => $room->getId()
        ]);

        $punishmentsInRoomBeforeAddNew = RoomPunishment::all();
        $this->assertSame(0, $punishmentsInRoomBeforeAddNew->count());

        $this->serviceImpl->addPunishmentsToRoom($contract);
        $punishmentsInRoomAfterAddNew = RoomPunishment::all();

        $this->assertSame($punishmentsCount, $punishmentsInRoomAfterAddNew->count());
    }

    public function test_UserEnterRoom_ShouldAddNewUserInRoom_WhenUserEnterInRoom(): void
    {
        $password = $this->faker->password();

        $room = Room::factory()->create([
            'user_id' => $this->user->getId(),
            'is_private' => true,
            'password' => Hash::make($password)
        ]);

        $contract = new UserEnterRoomRequest([
            'is_private' => true,
            'password' => $password,
            'room_id' => $room->getId()
        ]);

        $usersInRoomBeforeEnter = RoomUser::all();
        $this->assertSame(0, $usersInRoomBeforeEnter->count());

        $this->serviceImpl->userEnterRoom($contract, $this->user->getId());
        $usersInRoomAfterEnter = RoomUser::all();

        $this->assertSame(1, $usersInRoomAfterEnter->count());
    }

    public function test_UserLeaveRoom_ShouldDeleteUserFromRoom_WhenUserLeaveRoom(): void
    {
        $room = Room::factory()->create([
            'user_id' => $this->user->getId(),
        ]);

        RoomUser::factory()->create([
            'room_id' => $room->getId(),
            'user_id' => $this->user->getId()
        ]);

        $contract = new UserLeaveRoomRequest([
            'room_id' => $room->getId()
        ]);

        $usersInRoomBeforeEnter = RoomUser::all();
        $this->assertSame(1, $usersInRoomBeforeEnter->count());

        $this->serviceImpl->userLeaveRoom($contract, $this->user->getId());
        $usersInRoomAfterEnter = RoomUser::all();

        $this->assertSame(0, $usersInRoomAfterEnter->count());
    }

    public function test_GetAllUserQuestionsInRoom_ShouldReturnArrayWithTenElements(): void
    {
        $room = Room::factory()->create();
        $questionCount = 10;
        $questions = Question::factory($questionCount)->create(['user_id' => $this->user->getId()]);

        foreach ($questions as $question){
            RoomQuestion::factory()->create([
                'room_id' => $room->getId(),
                'question_id' => $question->getId()
            ]);
        }

        $questionsInRoom = $this->serviceImpl->getAllUserQuestionsInRoom($this->user->getId(), $room->getId());

        $this->assertSame($questionCount, count($questionsInRoom));
    }

    public function test_GetAllUserPunishmentsInRoom_ShouldReturnArrayWithTenElements(): void
    {
        $room = Room::factory()->create();
        $punishmentCount = 10;
        $punishments = Punishment::factory($punishmentCount)->create(['user_id' => $this->user->getId()]);

        foreach ($punishments as $punishment){
            RoomPunishment::factory()->create([
                'room_id' => $room->getId(),
                'punishment_id' => $punishment->getId()
            ]);
        }

        $punishmentInRoom = $this->serviceImpl->getAllUserPunishmentsInRoom($this->user->getId(), $room->getId());

        $this->assertSame($punishmentCount, count($punishmentInRoom));
    }

    public function test_GetUsersInRoom_ShouldReturnArrayWithTenElement(): void
    {
        $userCount = 10;
        $room = Room::factory()->create();

        RoomUser::factory($userCount)->create(['room_id' => $room->getId()]);

        $users = $this->serviceImpl->getUsersInRoom($room->getId());

        $this->assertSame($userCount, count($users));
    }

    public function test_DeleteQuestionsFromRoom_ShouldDeleteQuestionsFromRoom(): void
    {
        $questionsCount = 10;
        $questions = Question::factory($questionsCount)->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['user_id' => $this->user->getId()]);

        foreach ($questions as $question){
            RoomQuestion::factory()->create([
                'room_id' => $room->getId(),
                'question_id' => $question->getId()
            ]);
        }
        $contract = new DeleteQuestionsFromRoomRequest([
            'questions' => $questions->take($questionsCount/2)->pluck('id')->toArray(),
            'room_id' => $room->getId()
        ]);

        $questionsInRoomBeforeDelete = RoomQuestion::all();
        $this->assertSame($questionsCount, $questionsInRoomBeforeDelete->count());

        $this->serviceImpl->deleteQuestionsFromRoom($contract, $this->user->getId());
        $questionsInRoomAfterDelete = RoomQuestion::all();

        $this->assertSame($questionsCount/2, $questionsInRoomAfterDelete->count());
    }

    public function test_DeletePunishmentsFromRoom_ShouldDeletePunishmentsFromRoom(): void
    {
        $punishmentsCount = 10;
        $punishments = Punishment::factory($punishmentsCount)->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['user_id' => $this->user->getId()]);

        foreach ($punishments as $punishment) {
            RoomPunishment::factory()->create([
                'room_id' => $room->getId(),
                'punishment_id' => $punishment->getId()
            ]);
        }
        $contract = new DeletePunishmentsFromRoomRequest([
            'punishments' => $punishments->take($punishmentsCount / 2)->pluck('id')->toArray(),
            'room_id' => $room->getId()
        ]);

        $punishmentsInRoomBeforeDelete = RoomPunishment::all();
        $this->assertSame($punishmentsCount, $punishmentsInRoomBeforeDelete->count());

        $this->serviceImpl->deletePunishmentsFromRoom($contract, $this->user->getId());
        $punishmentsInRoomAfterDelete = RoomPunishment::all();

        $this->assertSame($punishmentsCount / 2, $punishmentsInRoomAfterDelete->count());
    }

    public function test_FindByIdOrFail_ShouldThrowRoomByIdNotFoundException_WhenRoomNotFound(): void
    {
        /** @var Room $room */
        $room = Room::factory()->create();
        $this->expectException(RoomByIdNotFoundException::class);
        $this->serviceImpl->findByIdOrFail($room->getId() + 1);
    }

    public function test_FindByIdOrFail_ShouldUserReadClass_WhenUserFind(): void
    {
        /** @var Room $room */
        $room = Room::factory()->create();

        $roomRead = $this->serviceImpl->findByIdOrFail($room->getId());

        $this->assertInstanceOf(RoomRead::class, $roomRead);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->serviceImpl = resolve(RoomService::class);
    }
}
