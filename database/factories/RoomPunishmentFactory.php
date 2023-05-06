<?php

namespace Database\Factories;

use App\Models\Punishment;
use App\Models\Room;
use App\Models\RoomPunishment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomPunishment>
 */
class RoomPunishmentFactory extends Factory
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
            'punishment_id' => Punishment::factory(),
            'in_game' => false,
            'is_used' => false
        ];
    }
}
