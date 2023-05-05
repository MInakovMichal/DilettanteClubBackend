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
 * @property int $author_id
 * @property int $is_private
 * @property int $language_id
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
 * @method static Builder|Room whereAuthorId($value)
 * @method static Builder|Room whereLanguageId($value)
 * @mixin Eloquent
 */
class Room extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'author_id',
        'name',
        'is_private',
        'password',
        'language_id',
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

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isPrivate(): bool
    {
        return $this->is_private;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->language_id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $author_id
     */
    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }

    /**
     * @param bool $is_private
     */
    public function setIsPrivate(bool $is_private): void
    {
        $this->is_private = $is_private ? 1 : 0;
    }

    /**
     * @param int $language_id
     */
    public function setLanguageId(int $language_id): void
    {
        $this->language_id = $language_id;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}
