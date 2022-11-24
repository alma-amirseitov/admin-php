<?php

declare(strict_types=1);

namespace App\Model\Validators;
use PHPUnit\Framework\TestCase;

class MessageValidatorTest extends TestCase
{
    public function testValidate(): void
    {
        $expected = [["message" => 'Поле "message" не должно быть пустым'],["message" => "Сообщение не может быть меньше 2 символов"], []];

        $validator = new MessageValidator();

        $actualOne = $validator->validate(["message" => ""]);
        $actualTwo = $validator->validate(["message" => "a"]);
        $actualThree = $validator->validate(["message" => "testing"]);

        $actual = [$actualOne, $actualTwo, $actualThree];

        $this->assertEquals($expected, $actual);
    }
}