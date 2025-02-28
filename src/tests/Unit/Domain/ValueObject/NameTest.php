<?php

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Src\Domain\Exception\InvalidNameException;
use Src\Domain\ValueObject\Name;

final class NameTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function test_valid_name(): void
    {
        $validName = $this->faker->firstName().' '.$this->faker->lastName();
        $name = new Name($validName);
        $this->assertSame($validName, $name->value());
    }

    public function test_empty_name_throws_exception(): void
    {
        $this->expectException(InvalidNameException::class);
        new Name('');
    }

    public function test_too_short_name_throws_exception(): void
    {
        $this->expectException(InvalidNameException::class);
        new Name('A');
    }
}
