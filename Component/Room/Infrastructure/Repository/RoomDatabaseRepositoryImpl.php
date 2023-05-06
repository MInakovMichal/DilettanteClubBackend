<?php

namespace Component\Room\Infrastructure\Repository;

use Illuminate\Support\Facades\DB;

class RoomDatabaseRepositoryImpl implements RoomDatabaseRepository
{
    private DB $db;

    /**
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }


    /**
     * @param int $roomId
     * @return array<int,mixed>
     */
    public function getUsersInRoom(int $roomId): array
    {
        return $this->db::select(
            "SELECT u.id, u.name, u.username
                    FROM room_users ru
                    LEFT JOIN users u ON ru.user_id = u.id AND u.deleted_at IS NULL
                    WHERE ru.room_id = :roomId
                    GROUP BY u.id
                    ORDER BY ru.created_at",
            [
                "roomId" => $roomId
            ]
        );
    }
}
