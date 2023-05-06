<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\RoomPunishment
 *
 * @property int $id
 * @property int $room_id
 * @property int $punishment_id
 * @property bool $in_game
 * @property bool $is_used
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|RoomPunishment newModelQuery()
 * @method static Builder|RoomPunishment newQuery()
 * @method static Builder|RoomPunishment query()
 * @method static Builder|RoomPunishment whereCreatedAt($value)
 * @method static Builder|RoomPunishment whereId($value)
 * @method static Builder|RoomPunishment whereInGame($value)
 * @method static Builder|RoomPunishment whereIsUsed($value)
 * @method static Builder|RoomPunishment wherePunishmentId($value)
 * @method static Builder|RoomPunishment whereRoomId($value)
 * @method static Builder|RoomPunishment whereUpdatedAt($value)
 * @mixin Eloquent
 */
class RoomPunishment extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'room_id',
        'punishment_id',
        'in_game',
        'is_used'
    ];

    protected $casts = [
        'in_game' => 'boolean',
        'is_used' => 'boolean',
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRoomId(): int
    {
        return $this->room_id;
    }

    /**
     * @return int
     */
    public function getPunishmentId(): int
    {
        return $this->punishment_id;
    }

    /**
     * @return bool
     */
    public function inGame(): bool
    {
        return $this->in_game;
    }

    /**
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->is_used;
    }

    /**
     * @param int $room_id
     */
    public function setRoomId(int $room_id): void
    {
        $this->room_id = $room_id;
    }

    /**
     * @param int $punishment_id
     */
    public function setPunishmentId(int $punishment_id): void
    {
        $this->punishment_id = $punishment_id;
    }

    /**
     * @param bool $in_game
     */
    public function setInGame(bool $in_game): void
    {
        $this->in_game = $in_game;
    }

    /**
     * @param bool $is_used
     */
    public function setIsUsed(bool $is_used): void
    {
        $this->is_used = $is_used;
    }
}
