<?php

namespace Src\Domain\ValueObject;

use Src\Domain\Exception\InvalidPasswordException;
use Src\Domain\Exception\WeakPasswordException;

class Password
{
    private string $hashedValue;

    public function __construct(string $plainPassword)
    {
        if (! $plainPassword) {
            throw new InvalidPasswordException;
        }
        if (! preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $plainPassword)) {
            throw new WeakPasswordException;
        }
        $this->hashedValue = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function value(): string
    {
        return $this->hashedValue;
    }
}
