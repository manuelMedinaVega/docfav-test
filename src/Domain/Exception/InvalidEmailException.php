<?php

namespace Src\Domain\Exception;

use Exception;

final class InvalidEmailException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid email format.');
    }
}
