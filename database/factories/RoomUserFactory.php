<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomUser>
 */
class RoomUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'user_id' => User::factory(),
            'is_ready' => false,
            'wins' => 0,
            'looses' => 0
        ];
    }
}
