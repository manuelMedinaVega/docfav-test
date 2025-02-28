<?php

namespace Src\Domain\Exception;

use Exception;

final class InvalidPasswordException extends Exception
{
    public function __construct()
    {
        parent::__construct('Password is not valid.');
    }
}
