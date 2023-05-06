<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property int $user_id
 * @property string $question
 * @property int $answer
 * @property int $use_count
 * @property int $language_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static QuestionFactory factory($count = null, $state = [])
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question onlyTrashed()
 * @method static Builder|Question query()
 * @method static Builder|Question whereAnswer($value)
 * @method static Builder|Question whereCreatedAt($value)
 * @method static Builder|Question whereDeletedAt($value)
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereLanguageId($value)
 * @method static Builder|Question whereQuestion($value)
 * @method static Builder|Question whereUpdatedAt($value)
 * @method static Builder|Question whereUseCount($value)
 * @method static Builder|Question whereUserId($value)
 * @method static Builder|Question withTrashed()
 * @method static Builder|Question withoutTrashed()
 * @mixin Eloquent
 */
class Question extends Model
{
    public $fillable = [
        'id',
        'user_id',
        'question',
        'answer',
        'use_count',
        'language_id',
    ];

    use HasFactory;
    use SoftDeletes;

    /**
     * @param int $use_count
     */
    public function setUseCount(int $use_count): void
    {
        $this->use_count = $use_count;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAnswer(): int
    {
        return $this->answer;
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
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * @param int $answer
     */
    public function setAnswer(int $answer): void
    {
        $this->answer = $answer;
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
