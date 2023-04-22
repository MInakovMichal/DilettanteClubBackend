<?php

namespace Tests\Unit\Models;

use App\Models\Language;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    private Language $language;

    private int $id;

    public function test_GetId_ShouldReturnLanguageId(): void
    {
        $this->assertSame($this->id, $this->language->getId());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = 1;
        $this->language = Language::factory()->make(['id' => $this->id]);
    }
}
