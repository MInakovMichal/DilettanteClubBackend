<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

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
use Component\Room\Infrastructure\Http\Requests\UserEnterRoomRequest;
use Component\Room\Infrastructure\Http\Requests\UserLeaveRoomRequest;
use Component\Room\Infrastructure\Repository\RoomRepository;
use Component\Room\Sdk\Model\RoomRead;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoomRepositoryImplTest extends TestCase
{
    private RoomRepository $repositoryImpl;

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

        $roomRead = $this->repositoryImpl->createRoom($contract, $this->user->getId());

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

        $this->repositoryImpl->addQuestionsToRoom($contract);
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

        $this->repositoryImpl->addPunishmentsToRoom($contract);
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

        $this->repositoryImpl->userEnterRoom($contract, $this->user->getId());
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

        $this->repositoryImpl->userLeaveRoom($contract, $this->user->getId());
        $usersInRoomAfterEnter = RoomUser::all();

        $this->assertSame(0, $usersInRoomAfterEnter->count());
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

        $questionsInRoom = $this->repositoryImpl->getAllUserQuestionsInRoom($this->user->getId(), $room->getId());

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

        $punishmentInRoom = $this->repositoryImpl->getAllUserPunishmentsInRoom($this->user->getId(), $room->getId());

        $this->assertSame($punishmentCount, count($punishmentInRoom));
    }

    public function test_GetUsersInRoom_ShouldReturnArrayWithTenElement(): void
    {
        $userCount = 10;
        $room = Room::factory()->create();

        RoomUser::factory($userCount)->create(['room_id' => $room->getId()]);

        $users = $this->repositoryImpl->getUsersInRoom($room->getId());

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

        $questionsInRoomBeforeDelete = RoomQuestion::all();
        $this->assertSame($questionsCount, $questionsInRoomBeforeDelete->count());

        foreach ($questions->take($questionsCount / 2) as $question) {
            $this->repositoryImpl->deleteQuestionsFromRoom($room->getId(), $question->getId());
        }

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

        $punishmentsInRoomBeforeDelete = RoomPunishment::all();
        $this->assertSame($punishmentsCount, $punishmentsInRoomBeforeDelete->count());

        foreach ($punishments->take($punishmentsCount / 2) as $punishment) {
            $this->repositoryImpl->deletePunishmentsFromRoom($room->getId(), $punishment->getId());
        }

        $punishmentsInRoomAfterDelete = RoomPunishment::all();

        $this->assertSame($punishmentsCount / 2, $punishmentsInRoomAfterDelete->count());
    }

    public function test_FindByIdOrFail_ShouldThrowRoomByIdNotFoundException_WhenRoomNotFound(): void
    {
        /** @var Room $room */
        $room = Room::factory()->create();
        $this->expectException(RoomByIdNotFoundException::class);
        $this->repositoryImpl->findByIdOrFail($room->getId() + 1);
    }

    public function test_FindByIdOrFail_ShouldUserReadClass_WhenUserFind(): void
    {
        /** @var Room $room */
        $room = Room::factory()->create();

        $roomRead = $this->repositoryImpl->findByIdOrFail($room->getId());

        $this->assertInstanceOf(RoomRead::class, $roomRead);
    }

    public function test_GEtAllPublicRoom_ShouldReturnArrayWithTenItems(): void
    {
        $roomsCount = 10;

        $rooms = Room::factory($roomsCount)->create(['is_private' => false]);
        foreach ($rooms as $room) {
            RoomUser::factory(5)->create(['room_id' => $room->getId()]);
        }
        $publicRooms = $this->repositoryImpl->getAllPublicRoomsWithUsersCount();

        $this->assertSame($roomsCount, count($publicRooms));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->repositoryImpl = resolve(RoomRepository::class);
    }
}
