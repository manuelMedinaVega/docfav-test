<?php

namespace Tests\Unit\Domain\Event;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Src\Domain\Event\UserRegisteredEvent;
use Src\Domain\ValueObject\Email;
use Src\Domain\ValueObject\UserId;

class UserRegisteredEventTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function test_event_contains_correct_data(): void
    {

        $userId = new UserId($this->faker->uuid());
        $email = new Email($this->faker->unique()->safeEmail());

        $event = new UserRegisteredEvent($userId, $email);

        $this->assertEquals($userId, $event->getUserId());
        $this->assertEquals($email, $event->getEmail());
        $this->assertInstanceOf(UserRegisteredEvent::class, $event);
    }
}
