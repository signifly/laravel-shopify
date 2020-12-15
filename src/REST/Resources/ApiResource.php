<?php

namespace Signifly\Shopify\REST\Resources;

use ArrayAccess;
use Exception;
use Illuminate\Support\Arr;
use Signifly\Shopify\REST\ResourceKey;
use Signifly\Shopify\REST\TransformsResources;
use Signifly\Shopify\Shopify;

abstract class ApiResource implements ArrayAccess
{
    use TransformsResources;

    protected array $attributes = [];

    protected Shopify $shopify;

    public function __construct(array $attributes, Shopify $shopify)
    {
        $this->attributes = $attributes;
        $this->shopify = $shopify;
    }

    /**
     * Get all of the attributes except for a specified array of keys.
     *
     * @param  array|string $keys
     * @return array
     */
    public function except($keys): array
    {
        return Arr::except($this->getAttributes(), is_array($keys) ? $keys : func_get_args());
    }

    /**
     * Get a subset of the attributes.
     *
     * @param  array|string $keys
     * @return array
     */
    public function only($keys): array
    {
        return Arr::only($this->getAttributes(), is_array($keys) ? $keys : func_get_args());
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->getAttribute($key);
        }

        throw new Exception('Property '.$key.' does not exist on '.get_called_class());
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        return $this->setAttribute($offset, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Get an attribute.
     *
     * @param  string $key
     * @return mixed
     */
    protected function getAttribute($key)
    {
        return $this->attributes[$key];
    }

    /**
     * Set an attribute.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Get attributes for the resource.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    protected function getResourceKey(): ResourceKey
    {
        return ResourceKey::fromResource(static::class);
    }
}
