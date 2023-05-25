<?php

namespace Tests\Unit\Component\Room\Infrastructure\Repository;

use App\Models\Punishment;
use App\Models\Question;
use App\Models\Room;
use App\Models\RoomPunishment;
use App\Models\RoomQuestion;
use App\Models\RoomUser;
use App\Models\User;
use Component\Room\Infrastructure\Repository\RoomDatabaseRepository;
use Tests\TestCase;

class RoomDatabaseRepositoryImplTest extends TestCase
{
    private RoomDatabaseRepository $repositoryImpl;
    private int $usersCount;
    private Room $room;
    private User $user;

    public function test_GetUsersInRoom_ShouldReturnCollectionWithTenElements(): void
    {
        $usersInRoom = $this->repositoryImpl->getUsersInRoom($this->room->getId());

        $this->assertSame($this->usersCount, count($usersInRoom));
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

    public function test_GetAllPublicRoom_ShouldReturnArrayWithTenItems(): void
    {
        $roomsCount = 10;

        $rooms = Room::factory($roomsCount)->create(['is_private' => false]);
        foreach ($rooms as $room) {
            RoomUser::factory(5)->create(['room_id' => $room->getId()]);
        }
        $publicRooms = $this->repositoryImpl->getAllPublicRoomsWithUsersCount();

        $this->assertSame($roomsCount, count($publicRooms));
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

        $questionNotInRoom = $this->repositoryImpl->getUserQuestionsNotInRoom($this->user->getId(), $room->getId());

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

        $punishmentNotInRoom = $this->repositoryImpl->getUserPunishmentsNotInRoom($this->user->getId(), $room->getId());

        $this->assertSame($punishmentInRoomCount, count($punishmentNotInRoom));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->usersCount = 10;
        $this->room = Room::factory()->create();
        RoomUser::factory($this->usersCount)->create([
            'room_id' => $this->room->getId()
        ]);

        $this->repositoryImpl = resolve(RoomDatabaseRepository::class);
    }

}
