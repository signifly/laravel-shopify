<?php

namespace Signifly\Shopify\Exceptions;

class ValidationException extends \Exception
{
    public function __construct(array $errors = [])
    {
        parent::__construct('The given data failed to pass validation.');
    }
}
