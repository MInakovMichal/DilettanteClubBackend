<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\RoomUser
 *
 * @property int $id
 * @property int $room_id
 * @property int $user_id
 * @property bool $is_ready
 * @property int $wins
 * @property int $looses
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|RoomUser newModelQuery()
 * @method static Builder|RoomUser newQuery()
 * @method static Builder|RoomUser query()
 * @method static Builder|RoomUser whereCreatedAt($value)
 * @method static Builder|RoomUser whereId($value)
 * @method static Builder|RoomUser whereIsReady($value)
 * @method static Builder|RoomUser whereLooses($value)
 * @method static Builder|RoomUser whereRoomId($value)
 * @method static Builder|RoomUser whereUpdatedAt($value)
 * @method static Builder|RoomUser whereUserId($value)
 * @method static Builder|RoomUser whereWins($value)
 * @mixin Eloquent
 */
class RoomUser extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'room_id',
        'user_id',
        'is_ready',
        'wins',
        'looses'
    ];

    protected $casts = [
        'is_ready' => 'boolean'
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
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return bool
     */
    public function isReady(): bool
    {
        return $this->is_ready;
    }

    /**
     * @return int
     */
    public function getWins(): int
    {
        return $this->wins;
    }

    /**
     * @return int
     */
    public function getLooses(): int
    {
        return $this->looses;
    }

    /**
     * @param int $room_id
     */
    public function setRoomId(int $room_id): void
    {
        $this->room_id = $room_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @param bool $is_ready
     */
    public function setIsReady(bool $is_ready): void
    {
        $this->is_ready = $is_ready;
    }

    /**
     * @param int $wins
     */
    public function setWins(int $wins): void
    {
        $this->wins = $wins;
    }

    /**
     * @param int $looses
     */
    public function setLooses(int $looses): void
    {
        $this->looses = $looses;
    }
}
