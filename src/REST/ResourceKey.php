<?php

namespace Signifly\Shopify\REST;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

/**
 * @internal
 */
class ResourceKey
{
    protected Stringable $name;

    public function __construct(string $name)
    {
        $this->name = Str::of($name)->snake()->lower();
    }

    public static function fromAction(string $class): self
    {
        $name = Str::of((new \ReflectionClass($class))->getShortName())->before('Action');

        return new self($name);
    }

    public static function fromResource(string $class): self
    {
        $name = Str::of((new \ReflectionClass($class))->getShortName())->before('Resource');

        return new self($name);
    }

    public function studly(): string
    {
        return $this->name->studly();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function plural(): string
    {
        return $this->name->plural();
    }

    public function singular(): string
    {
        return $this->name->singular();
    }
}
