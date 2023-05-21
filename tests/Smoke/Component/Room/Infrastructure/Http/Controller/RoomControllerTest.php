<?php

namespace Tests\Smoke\Component\Room\Infrastructure\Http\Controller;

use App\Models\Language;
use App\Models\Punishment;
use App\Models\Question;
use App\Models\Room;
use App\Models\RoomPunishment;
use App\Models\RoomQuestion;
use App\Models\RoomUser;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoomControllerTest extends TestCase
{
    public function test_CreateRoom(): void
    {
        $user = User::factory()->create();

        /** @var Language $language */
        $language = Language::firstOrFail();

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.rooms.create"),
            [
                "name" => $this->faker->name(),
                "language_id" => $language->getId(),
                "is_private" => true,
                "password" => 'Password123#',
                "password_confirmation" => 'Password123#'
            ]
        );

        $response->assertStatus(200);
    }

    public function test_CloseRoom(): void
    {
        $user = User::factory()->create();

        $room = Room::factory()->create(['user_id' => $user->getId()]);

        $response = $this->actingAs($user, "api")->json(
            "DELETE",
            route("user.rooms.close"),
            [
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_AddQuestionsToRoom(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['user_id' => $user->getId()]);

        /** @var Collection $questions */
        $questions = Question::factory(10)->create();

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.rooms.questions.add"),
            [
                "questions" => $questions->pluck('id'),
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_AddPunishmentsToRoom(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['user_id' => $user->getId()]);

        /** @var Collection $punishments */
        $punishments = Punishment::factory(10)->create();

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.rooms.punishments.add"),
            [
                "punishments" => $punishments->pluck('id'),
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_UsersEnterRoom(): void
    {
        $user = User::factory()->create();
        $password = 'Password123#';
        $room = Room::factory()->create(['user_id' => $user->getId(), 'password' => Hash::make($password)]);

        $usersCount = 10;
        RoomUser::factory($usersCount)->create([
            'room_id' => $room->getId()
        ]);

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.rooms.users.enter"),
            [
                "password" => $password,
                "is_private" => true,
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_UsersLeaveRoom(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['user_id' => $user->getId()]);

        RoomUser::factory()->create(['user_id' => $user->getId(), 'room_id' => $room->getId()]);

        $response = $this->actingAs($user, "api")->json(
            "POST",
            route("user.rooms.users.leave"),
            [
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_DeleteQuestionsFromRoom(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $questions = Question::factory(10)->create(['user_id' => $user->getId()]);
        foreach ($questions as $question) {
            RoomQuestion::factory()->create([
                'room_id' => $room->getId(),
                'question_id' => $question->getId()
            ]);
        }
        $deleteQuestion = Question::get()->take(5);

        $response = $this->actingAs($user, "api")->json(
            "DELETE",
            route("user.rooms.questions.delete"),
            [
                "questions" => $deleteQuestion->pluck('id'),
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_DeletePunishmentsFromRoom(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $punishments = Punishment::factory(10)->create(['user_id' => $user->getId()]);
        foreach ($punishments as $punishment) {
            RoomPunishment::factory()->create([
                'room_id' => $room->getId(),
                'punishment_id' => $punishment->getId()
            ]);
        }
        $deletePunishment = Punishment::get()->take(5);

        $response = $this->actingAs($user, "api")->json(
            "DELETE",
            route("user.rooms.punishments.delete"),
            [
                "punishments" => $deletePunishment->pluck('id'),
                "room_id" => $room->getId(),
            ]
        );

        $response->assertStatus(200);
    }

    public function test_GetAllPublicRooms(): void
    {
        $user = User::factory()->create();
//        $rooms = Room::factory(10)->create(['is_private' => rand(0, 1)]);
//        foreach ($rooms as $room) {
//            RoomUser::factory($this->faker->numberBetween(5, 25))->create([
//                'room_id' => $room->getId(),
//            ]);
//        }

        $response = $this->actingAs($user, "api")->json(
            "GET",
            route("user.rooms.public.all"));

        $response->assertStatus(200);
    }
}
