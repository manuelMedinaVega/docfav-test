<?php

namespace Src\Domain\ValueObject;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Src\Domain\Exception\InvalidUuidException;

class UserId
{
    private UuidInterface $id;

    public function __construct(?string $id = null)
    {
        try {
            $this->id = $id ? Uuid::fromString($id) : Uuid::uuid4();
        } catch (InvalidUuidStringException $e) {
            throw new InvalidUuidException;
        }

    }

    public function value(): string
    {
        return $this->id->toString();
    }
}
