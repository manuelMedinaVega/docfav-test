<?php

namespace Src\Domain\Exception;

use Exception;

final class InvalidNameException extends Exception
{
    public function __construct()
    {
        parent::__construct('Name is not valid.');
    }
}
