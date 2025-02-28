<?php

namespace Src\Domain\Exception;

use Exception;

final class InvalidUuidException extends Exception
{
    public function __construct()
    {
        parent::__construct('UUID is not valid.');
    }
}
