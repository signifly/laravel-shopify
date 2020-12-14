<?php

namespace Signifly\Shopify\REST;

use Signifly\Shopify\Exceptions\InvalidFormatException;

class Path
{
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    const VALID_FORMATS = [
        self::FORMAT_JSON,
        self::FORMAT_XML,
    ];

    protected ?string $appends = null;

    protected string $format = self::FORMAT_JSON;

    protected ?int $id = null;

    protected array $params = [];

    protected ?string $prepends = null;

    protected ResourceKey $resourceKey;

    public function __construct(ResourceKey $resourceKey)
    {
        $this->resourceKey = $resourceKey;
    }

    public static function make(ResourceKey $resourceKey): self
    {
        return new self($resourceKey);
    }

    public function appends(string $appends): self
    {
        $this->appends = $appends;

        return $this;
    }

    public function build(): string
    {
        $path = collect([
            $this->prepends,
            $this->resourceKey->plural(),
            $this->id,
            $this->appends,
        ])
        ->filter()
        ->implode('/');

        $uri = "{$path}.{$this->format}";

        return $this->hasParams() ? $uri.'?'.http_build_query($this->params) : $uri;
    }

    public function format(string $format): self
    {
        if (! in_array($format, self::VALID_FORMATS)) {
            throw InvalidFormatException::for($format);
        }

        $this->format = $format;

        return $this;
    }

    public function hasParams(): bool
    {
        return count($this->params) > 0;
    }

    public function withId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function prepends(string $prepends): self
    {
        $this->prepends = $prepends;

        return $this;
    }

    public function withParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function __toString()
    {
        return $this->build();
    }
}
