<?php

namespace App\Models;

use Database\Factories\PunishmentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Punishment
 *
 * @property int $id
 * @property int $user_id
 * @property string $punishment
 * @property int $use_count
 * @property int $language_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static PunishmentFactory factory($count = null, $state = [])
 * @method static Builder|Punishment newModelQuery()
 * @method static Builder|Punishment newQuery()
 * @method static Builder|Punishment query()
 * @method static Builder|Punishment whereCreatedAt($value)
 * @method static Builder|Punishment whereDeletedAt($value)
 * @method static Builder|Punishment whereId($value)
 * @method static Builder|Punishment whereLanguageId($value)
 * @method static Builder|Punishment wherePunishment($value)
 * @method static Builder|Punishment whereUpdatedAt($value)
 * @method static Builder|Punishment whereUseCount($value)
 * @method static Builder|Punishment whereUserId($value)
 * @mixin Eloquent
 */
class Punishment extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'user_id',
        'punishment',
        'use_count',
        'language_id',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getPunishment(): string
    {
        return $this->punishment;
    }

    public function getUseCount(): int
    {
        return $this->use_count;
    }

    public function getLanguageId(): int
    {
        return $this->language_id;
    }

    /**
     * @param string $punishment
     */
    public function setPunishment(string $punishment): void
    {
        $this->punishment = $punishment;
    }

    /**
     * @param int $language_id
     */
    public function setLanguageId(int $language_id): void
    {
        $this->language_id = $language_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }
}
