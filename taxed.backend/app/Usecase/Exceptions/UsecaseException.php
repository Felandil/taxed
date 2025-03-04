<?php

namespace App\Usecase\Exceptions;

use \Exception;

class UsecaseException extends Exception
{
    public function __construct(int $code)
    {
        $this->code = $code;

        parent::__construct("Invalid asset category");
    }
}