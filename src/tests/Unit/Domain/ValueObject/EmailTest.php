<?php

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Src\Domain\Exception\InvalidEmailException;
use Src\Domain\ValueObject\Email;

final class EmailTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function test_valid_email(): void
    {
        $validEmail = $this->faker->unique()->safeEmail();
        $email = new Email($validEmail);
        $this->assertSame($validEmail, $email->value());
    }

    public function test_invalid_email_throws_exception(): void
    {
        $this->expectException(InvalidEmailException::class);
        new Email('invalid-email');
    }
}
