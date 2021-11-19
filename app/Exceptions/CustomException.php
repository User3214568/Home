<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{

    public function __construct($msg)
    {
        parent::__construct("$msg");
    }

}
