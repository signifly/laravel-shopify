<?php

namespace Signifly\Shopify\Exceptions;

class ValidationException extends \Exception
{
    public array $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;

        parent::__construct('The given data failed to pass validation.');
    }
}
