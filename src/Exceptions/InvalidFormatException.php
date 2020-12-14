<?php

namespace Signifly\Shopify\Exceptions;

class InvalidFormatException extends \Exception
{
    public static function for(string $format): self
    {
        return new static(sprintf('Invalid format `%s` provided.', $format));
    }
}
