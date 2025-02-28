<?php

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Src\Domain\Entity\User;
use Src\Domain\ValueObject\Email;
use Src\Domain\ValueObject\Name;
use Src\Domain\ValueObject\Password;
use Src\Domain\ValueObject\UserId;

final class UserTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function test_user_creation(): void
    {
        $userId = new UserId($this->faker->uuid());
        $name = new Name($this->faker->firstName().' '.$this->faker->lastName());
        $email = new Email($this->faker->unique()->safeEmail());
        $password = new Password($this->faker->password(8, 16).'A@1');

        $user = new User($userId, $name, $email, $password);

        $this->assertSame($userId->value(), $user->getId()->value());
        $this->assertSame($name->value(), $user->getName()->value());
        $this->assertSame($email->value(), $user->getEmail()->value());
    }
}
