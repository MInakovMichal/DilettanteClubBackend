<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Room
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $is_private
 * @property string|null $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static RoomFactory factory($count = null, $state = [])
 * @method static Builder|Room newModelQuery()
 * @method static Builder|Room newQuery()
 * @method static Builder|Room query()
 * @method static Builder|Room whereCreatedAt($value)
 * @method static Builder|Room whereDeletedAt($value)
 * @method static Builder|Room whereId($value)
 * @method static Builder|Room whereIsPrivate($value)
 * @method static Builder|Room whereName($value)
 * @method static Builder|Room wherePassword($value)
 * @method static Builder|Room whereUpdatedAt($value)
 * @method static Builder|Room whereUserId($value)
 * @mixin Eloquent
 */
class Room extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'user_id',
        'name',
        'is_private',
        'password',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    protected $hidden = [
        'password',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isPrivate(): bool
    {
        /** @var bool $isPrivate */
        $isPrivate = $this->is_private;

        return $isPrivate;
    }
}
