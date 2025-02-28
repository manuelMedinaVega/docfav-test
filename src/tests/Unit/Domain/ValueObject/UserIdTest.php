<?php

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Src\Domain\Exception\InvalidUuidException;
use Src\Domain\ValueObject\UserId;

final class UserIdTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function test_valid_uuid(): void
    {
        $uuid = $this->faker->uuid();
        $userId = new UserId($uuid);

        $this->assertSame($uuid, $userId->value());
    }

    public function test_invalid_uuid_throws_exception(): void
    {
        $this->expectException(InvalidUuidException::class);
        new UserId('invalid-uuid');
    }
}
