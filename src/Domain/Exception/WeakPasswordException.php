<?php

namespace Src\Domain\Exception;

use Exception;

final class WeakPasswordException extends Exception
{
    public function __construct()
    {
        parent::__construct('Password is too weak. It must be at least 8 characters long, include one uppercase letter, one number, and one special character.');
    }
}
