<?php

namespace Src\Presentation\Exception;

use Exception;

class EmailAlreadyInUseException extends Exception
{
    public function __construct()
    {
        parent::__construct('Email is already in use.');
    }
}
