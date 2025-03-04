<?php

namespace App\Usecase\Exceptions;

use \Exception;

/**
 * Exception thrown in a usecase, carries a descriptive code
 */
class UsecaseException extends Exception
{
    /**
     * @param int $code
     */
    public function __construct(int $code)
    {
        $this->code = $code;

        parent::__construct("Invalid asset category");
    }
}