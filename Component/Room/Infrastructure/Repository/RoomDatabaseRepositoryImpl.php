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
     * @return array<array-key, mixed>
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

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserQuestionsInRoom(int $authUserId, int $roomId): array
    {
        return $this->db::select(
            "SELECT q.id, q.question, q.answer
                    FROM room_questions rq
                    LEFT JOIN questions q ON rq.question_id = q.id AND q.deleted_at IS NULL AND q.user_id = :userId
                    WHERE rq.room_id = :roomId
                    GROUP BY q.id
                    ORDER BY rq.created_at",
            [
                "userId" => $authUserId,
                "roomId" => $roomId
            ]
        );
    }

    /**
     * @param int $authUserId
     * @param int $roomId
     * @return array<array-key, mixed>
     */
    public function getAllUserPunishmentsInRoom(int $authUserId, int $roomId): array
    {
        return $this->db::select(
            "SELECT p.id, p.punishment
                    FROM room_punishments rp
                    LEFT JOIN punishments p ON rp.punishment_id = p.id AND p.deleted_at IS NULL AND p.user_id = :userId
                    WHERE rp.room_id = :roomId
                    GROUP BY p.id
                    ORDER BY rp.created_at",
            [
                "userId" => $authUserId,
                "roomId" => $roomId
            ]
        );
    }
}
