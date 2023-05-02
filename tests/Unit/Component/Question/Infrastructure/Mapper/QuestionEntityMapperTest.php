<?php

namespace Tests\Unit\Component\Question\Infrastructure\Mapper;

use App\Models\Question;
use Component\Question\Infrastructure\Mapper\QuestionEntityMapper;
use Component\Question\Sdk\Model\QuestionRead;
use Tests\TestCase;

class QuestionEntityMapperTest extends TestCase
{
    private QuestionEntityMapper $mapper;

    public function test_MapToReadModel_ShouldReturnQuestionReadModel()
    {
        $Question = Question::factory()->make(['id' => 1]);
        $response = $this->mapper->mapToReadModel($Question);
        $this->assertInstanceOf(QuestionRead::class, $response);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = resolve(QuestionEntityMapper::class);
    }
}
