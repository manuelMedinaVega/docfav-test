<?php

namespace Src\Domain\Event;

use DateTimeImmutable;
use Src\Domain\ValueObject\Email;
use Src\Domain\ValueObject\UserId;

class UserRegisteredEvent
{
    private UserId $userId;

    private Email $email;

    private DateTimeImmutable $occurredOn;

    public function __construct(UserId $userId, Email $email)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->occurredOn = new DateTimeImmutable;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
