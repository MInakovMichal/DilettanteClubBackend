<?php

namespace Tests\Unit\Models;

use App\Models\Language;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    private Language $language;

    private int $id;

    private string $name;

    private string $code;

    public function test_GetId_ShouldReturnLanguageId(): void
    {
        $this->assertSame($this->id, $this->language->getId());
    }

    public function test_GetName_ShouldReturnName(): void
    {
        $this->assertSame($this->name, $this->language->getName());
    }

    public function test_GetCode_ShouldReturnCode(): void
    {
        $this->assertSame($this->code, $this->language->getCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = 1;
        $this->name = 'test name';
        $this->code = 'test code';
        $this->language = Language::factory()->make(['id' => $this->id, 'name' => $this->name, 'code' => $this->code]);
    }
}
