<?php

namespace Signifly\Shopify\Exceptions;

class ValidationException extends \Exception
{
    public array $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;

        parent::__construct(
            config('shopify.exceptions.include_validation_errors', false)
            ? 'Validation failed due to: '.json_encode($this->errors)
            : 'The given data failed to pass validation.'
        );
    }
}
