<?php

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Src\Domain\Exception\InvalidPasswordException;
use Src\Domain\Exception\WeakPasswordException;
use Src\Domain\ValueObject\Password;

final class PasswordTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function test_valid_password(): void
    {
        $validPassword = $this->faker->password(8, 20).'@A1';
        $password = new Password($validPassword);
        $this->assertTrue(password_verify($validPassword, $password->value()));
    }

    public function test_weak_password_throws_exception(): void
    {
        $this->expectException(WeakPasswordException::class);
        new Password($this->faker->password(1, 3));
    }

    public function test_empty_password_throws_exception(): void
    {
        $this->expectException(InvalidPasswordException::class);
        new Password('');
    }
}
