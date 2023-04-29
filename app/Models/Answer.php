<?php

namespace App\Models;

use Database\Factories\AnswerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Answer
 *
 * @property int $id
 * @property int $user_id
 * @property string $answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static AnswerFactory factory($count = null, $state = [])
 * @method static Builder|Answer newModelQuery()
 * @method static Builder|Answer newQuery()
 * @method static Builder|Answer query()
 * @method static Builder|Answer whereAnswer($value)
 * @method static Builder|Answer whereCreatedAt($value)
 * @method static Builder|Answer whereDeletedAt($value)
 * @method static Builder|Answer whereId($value)
 * @method static Builder|Answer whereUpdatedAt($value)
 * @method static Builder|Answer whereUserId($value)
 * @mixin Eloquent
 */
class Answer extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'user_id',
        'answer',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }
}
