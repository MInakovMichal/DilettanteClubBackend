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
        'question',
        'punishment',
        'use_count',
        'language_id',
    ];
}
