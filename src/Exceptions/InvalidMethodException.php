<?php

namespace Signifly\Shopify\Exceptions;

class InvalidMethodException extends \Exception
{
    public function __construct($message = 'Method not allowed. Check out the documentation.')
    {
        parent::__construct($message);
    }
}
