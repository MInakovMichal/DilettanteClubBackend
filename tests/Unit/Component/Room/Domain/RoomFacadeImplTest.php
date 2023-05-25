<?php

namespace Tests\Unit\Component\Room\Domain;

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
use Component\Room\Sdk\Model\RoomRead;
use Component\Room\Sdk\RoomFacade;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoomFacadeImplTest extends TestCase
{
    private RoomFacade $facadeImpl;

    private User $user;

    public function test_CreateRoom_ShouldReturnRoomReadClass_WhenUserCreateRoom(): void
    {
        $roomValue = $this->faker->name();

        /** @var Language $language */
        $language = Language::firstOrFail();

        $contract = new CreateRoomRequest([
            'name' => $roomValue,
            'is_private' => true,
            'password' => $this->faker->password(),
            'language_id' => $language->getId()
        ]);

        $roomRead = $this->facadeImpl->createRoom($contract, $this->user->getId());

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

        $this->facadeImpl->addQuestionsToRoom($contract, $room->getId());
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

        $this->facadeImpl->addPunishmentsToRoom($contract, $room->getId());
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

        $this->facadeImpl->userEnterRoom($contract, $this->user->getId());
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

        $usersInRoomBeforeEnter = RoomUser::all();
        $this->assertSame(1, $usersInRoomBeforeEnter->count());

        $this->facadeImpl->userLeaveRoom($room->getId(), $this->user->getId());
        $usersInRoomAfterEnter = RoomUser::all();

        $this->assertSame(0, $usersInRoomAfterEnter->count());
    }

    public function test_GetUsersInRoom_ShouldReturnArrayWithTenElement(): void
    {
        $userCount = 10;
        $room = Room::factory()->create();

        RoomUser::factory($userCount)->create(['room_id' => $room->getId()]);

        $users = $this->facadeImpl->getUsersInRoom($room->getId());

        $this->assertSame($userCount, count($users));
    }

    public function test_DeleteQuestionsFromRoom_ShouldDeleteQuestionsFromRoom(): void
    {
        $questionsCount = 10;
        $questions = Question::factory($questionsCount)->create(['user_id' => $this->user->getId()]);
        $room = Room::factory()->create(['user_id' => $this->user->getId()]);

        foreach ($questions as $question) {
            RoomQuestion::factory()->create([
                'room_id' => $room->getId(),
                'question_id' => $question->getId()
            ]);
        }
        $contract = new DeleteQuestionsFromRoomRequest([
            'questions' => $questions->take($questionsCount / 2)->pluck('id')->toArray(),
        ]);

        $questionsInRoomBeforeDelete = RoomQuestion::all();
        $this->assertSame($questionsCount, $questionsInRoomBeforeDelete->count());

        $this->facadeImpl->deleteQuestionsFromRoom($contract, $this->user->getId(), $room->getId());
        $questionsInRoomAfterDelete = RoomQuestion::all();

        $this->assertSame($questionsCount / 2, $questionsInRoomAfterDelete->count());
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
        ]);

        $punishmentsInRoomBeforeDelete = RoomPunishment::all();
        $this->assertSame($punishmentsCount, $punishmentsInRoomBeforeDelete->count());

        $this->facadeImpl->deletePunishmentsFromRoom($contract, $this->user->getId(), $room->getId());
        $punishmentsInRoomAfterDelete = RoomPunishment::all();

        $this->assertSame($punishmentsCount / 2, $punishmentsInRoomAfterDelete->count());
    }

    public function test_GetAllUserQuestionsInRoom_ShouldReturnArrayWithTenElements(): void
    {
        $room = Room::factory()->create();
        $questionCount = 10;
        $questions = Question::factory($questionCount)->create(['user_id' => $this->user->getId()]);

        foreach ($questions as $question) {
            RoomQuestion::factory()->create([
                'room_id' => $room->getId(),
                'question_id' => $question->getId()
            ]);
        }

        $questionsInRoom = $this->facadeImpl->getAllUserQuestionsInRoom($this->user->getId(), $room->getId());

        $this->assertSame($questionCount, count($questionsInRoom));
    }

    public function test_GetAllUserPunishmentsInRoom_ShouldReturnArrayWithTenElements(): void
    {
        $room = Room::factory()->create();
        $punishmentCount = 10;
        $punishments = Punishment::factory($punishmentCount)->create(['user_id' => $this->user->getId()]);

        foreach ($punishments as $punishment) {
            RoomPunishment::factory()->create([
                'room_id' => $room->getId(),
                'punishment_id' => $punishment->getId()
            ]);
        }

        $punishmentInRoom = $this->facadeImpl->getAllUserPunishmentsInRoom($this->user->getId(), $room->getId());

        $this->assertSame($punishmentCount, count($punishmentInRoom));
    }

    public function test_FindByIdOrFail_ShouldThrowRoomByIdNotFoundException_WhenRoomNotFound(): void
    {
        /** @var Room $room */
        $room = Room::factory()->create();
        $this->expectException(RoomByIdNotFoundException::class);
        $this->facadeImpl->findByIdOrFail($room->getId() + 1);
    }

    public function test_FindByIdOrFail_ShouldUserReadClass_WhenUserFind(): void
    {
        /** @var Room $room */
        $room = Room::factory()->create();

        $roomRead = $this->facadeImpl->findByIdOrFail($room->getId());

        $this->assertInstanceOf(RoomRead::class, $roomRead);
    }

    public function test_GetAllPublicRoom_ShouldReturnArrayWithTenItems(): void
    {
        $roomsCount = 10;

        $rooms = Room::factory($roomsCount)->create(['is_private' => false]);
        foreach ($rooms as $room) {
            RoomUser::factory(5)->create(['room_id' => $room->getId()]);
        }
        $publicRooms = $this->facadeImpl->getAllPublicRoomsWithUsersCount();

        $this->assertSame($roomsCount, count($publicRooms));
    }

    public function test_GetRoomDetails_ShouldReturnArrayWithQuestionsAndPunishmentAndUsers(): void
    {
        $count = 10;
        $room = Room::factory()->create(['is_private' => false]);
        RoomUser::factory()->create(['user_id' => $this->user->getId(), 'room_id' => $room->getId()]);
        $questions = Question::factory($count)->create(['user_id' => $this->user->getId()]);
        $punishments = Punishment::factory($count)->create(['user_id' => $this->user->getId()]);
        $users = User::factory($count)->create();

        foreach ($questions as $question) {
            RoomQuestion::factory()->create(['question_id' => $question->getId(), 'room_id' => $room->getId()]);
        }
        foreach ($punishments as $punishment) {
            RoomPunishment::factory()->create(['punishment_id' => $punishment->getId(), 'room_id' => $room->getId()]);
        }
        foreach ($users as $user) {
            RoomUser::factory()->create(['user_id' => $user->getId(), 'room_id' => $room->getId()]);
        }

        $roomDetails = $this->facadeImpl->getRoomDetails($room->getId(), $this->user->getId());

        $this->assertArrayHasKey('room', $roomDetails);
        $this->assertArrayHasKey('users', $roomDetails);
        $this->assertArrayHasKey('questions', $roomDetails);
        $this->assertArrayHasKey('punishments', $roomDetails);
    }

    public function test_GetUserQuestionsNotInRoom_ShouldReturnArrayWithTenItems(): void
    {
        $questionsCount = 20;
        $questionsInRoomCount = $questionsCount / 2;

        $questions = Question::factory($questionsCount)->create(['user_id' => $this->user->getId()]);

        $room = Room::factory()->create();

        foreach ($questions->take($questionsInRoomCount) as $question) {
            RoomQuestion::factory()->create(['room_id' => $room->getId(), 'question_id' => $question->getId()]);
        }

        $questionNotInRoom = $this->facadeImpl->getUserQuestionsNotInRoom($this->user->getId(), $room->getId());

        $this->assertSame($questionsInRoomCount, count($questionNotInRoom));
    }

    public function test_GetUserPunishmentsNotInRoom_ShouldReturnArrayWithTenItems(): void
    {
        $punishmentCount = 20;
        $punishmentInRoomCount = $punishmentCount / 2;

        $punishments = Punishment::factory($punishmentCount)->create(['user_id' => $this->user->getId()]);

        $room = Room::factory()->create();

        foreach ($punishments->take($punishmentInRoomCount) as $punishment) {
            RoomPunishment::factory()->create(['room_id' => $room->getId(), 'punishment_id' => $punishment->getId()]);
        }

        $punishmentNotInRoom = $this->facadeImpl->getUserPunishmentsNotInRoom($this->user->getId(), $room->getId());

        $this->assertSame($punishmentInRoomCount, count($punishmentNotInRoom));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->facadeImpl = resolve(RoomFacade::class);
    }
}
