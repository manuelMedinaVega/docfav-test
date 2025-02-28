<?php

namespace Src\Domain\ValueObject;

use Src\Domain\Exception\InvalidNameException;

class Name
{
    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 3 || ! preg_match('/^[\p{L}\s]+$/u', $name)) {
            throw new InvalidNameException;
        }
        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }
}
