<?php

namespace App\Exceptions;

use Exception;

class ImportException extends Exception
{
    public function __construct($data)
    {
       parent::__construct($data);
    }
}
