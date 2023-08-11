<?php

namespace System\Exceptions;

use Exception;
use Rakit\Validation\ErrorBag;

class ExcValidation extends Exception
{
    protected ErrorBag $errors;

    public function __construct($msg, ErrorBag $errors)
    {
        parent::__construct($msg);
        $this->errors = $errors;
    }

    public function getBag()
    {
        return $this->errors;
    }
}