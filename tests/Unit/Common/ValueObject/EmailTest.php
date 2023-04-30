<?php

namespace Tests\Unit\Common\ValueObject;

use Common\Exception\InvalidArgumentException;
use Common\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function test_Construct_ShouldThrowInvalidArgumentException_WhenPassedValueIsWrong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $wrongValue = 'not email';
        new Email($wrongValue);
    }

    public function test_Construct_ShouldCreateValueObject_WhenPassedValueIsCorrect(): void
    {
        $correctValue = 'example@gmail.com';
        $valueObject = new Email($correctValue);

        $this->assertInstanceOf(Email::class, $valueObject);

        $expectedValue = 'example@gmail.com';

        $this->assertSame($expectedValue, $valueObject->getEmailAddress());
    }

    public function test_Equals_ShouldReturnFalse_WhenTwoEmailsAreNotSame(): void
    {
        $firstEmail = 'first@gmail.com';
        $firstValueObject = new Email($firstEmail);

        $secondEmail = 'second@gmail.com';
        $secondValueObject = new Email($secondEmail);

        $isEquals = $firstValueObject->equals($secondValueObject);

        $this->assertFalse($isEquals);
    }

    public function test_Equals_ShouldReturnTrue_WhenTwoEmailsAreSame(): void
    {
        $firstEmail = 'same@gmail.com';
        $firstValueObject = new Email($firstEmail);

        $secondEmail = 'same@gmail.com';
        $secondValueObject = new Email($secondEmail);

        $isEquals = $firstValueObject->equals($secondValueObject);

        $this->assertTrue($isEquals);
    }
}
