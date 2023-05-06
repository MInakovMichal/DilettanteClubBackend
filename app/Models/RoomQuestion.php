<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\RoomQuestion
 *
 * @property int $id
 * @property int $room_id
 * @property int $question_id
 * @property bool $in_game
 * @property bool $is_used
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|RoomQuestion newModelQuery()
 * @method static Builder|RoomQuestion newQuery()
 * @method static Builder|RoomQuestion query()
 * @method static Builder|RoomQuestion whereCreatedAt($value)
 * @method static Builder|RoomQuestion whereId($value)
 * @method static Builder|RoomQuestion whereInGame($value)
 * @method static Builder|RoomQuestion whereIsUsed($value)
 * @method static Builder|RoomQuestion whereQuestionId($value)
 * @method static Builder|RoomQuestion whereRoomId($value)
 * @method static Builder|RoomQuestion whereUpdatedAt($value)
 * @mixin Eloquent
 */
class RoomQuestion extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'room_id',
        'question_id',
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
    public function getQuestionId(): int
    {
        return $this->question_id;
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
     * @param int $question_id
     */
    public function setQuestionId(int $question_id): void
    {
        $this->question_id = $question_id;
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
