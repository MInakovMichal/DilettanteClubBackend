<?php

namespace Tests\Unit\Common\ValueObject;

use Common\ValueObject\RoleValueObject;
use InvalidArgumentException;
use Tests\TestCase;

class RoleValueObjectTest extends TestCase
{
    public function test_User_ShouldReturnObjectWithStringValueEqualsUser(): void
    {
        $expectedValue = 'user';
        $actualValue = RoleValueObject::user()->getValue();
        $this->assertSame($expectedValue, $actualValue);
    }

    public function test_Admin_ShouldReturnObjectWithStringValueEqualsAdmin(): void
    {
        $expectedValue = 'admin';
        $actualValue = RoleValueObject::admin()->getValue();
        $this->assertSame($expectedValue, $actualValue);
    }

    public function test_Available_ShouldReturnArrayWithAdminAndUserValues(): void
    {
        $expectedValue = [
            'admin',
            'user',
        ];
        $actualValue = RoleValueObject::available();
        $this->assertSame($expectedValue, $actualValue);
    }

    public function test_Construct_ShouldThrowInvalidArgumentException_WhenPassedValueIsWrong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $wrongValue = 'user_incorrect';
        new RoleValueObject($wrongValue);
    }

    public function test_Construct_ShouldCreateValueObject_WhenPassedValueIsCorrect(): void
    {
        $correctValue = 'user';
        $valueObject = new RoleValueObject($correctValue);
        $expectedValue = 'user';
        $this->assertSame($expectedValue, $valueObject->getValue());
    }
}
