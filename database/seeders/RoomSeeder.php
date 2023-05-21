<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = Room::factory(10)->create();

        foreach ($rooms as $room) {
            $userCount = rand(5, 25);

            RoomUser::factory($userCount)->create(['room_id' => $room->getId()]);
        }
    }
}
