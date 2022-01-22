<?php

namespace SKprods\Telegram\Objects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;

abstract class BaseObject implements Arrayable, Jsonable
{
    protected array $properties;

    public function __construct(array $properties = [])
    {
        $this->properties = $properties;
    }

    /** Cast properties to object */
    abstract protected function casts(): array;

    /** Default values if property is null */
    protected function defaults(): array
    {
        return [];
    }

    /** Magically access to property */
    public function __get(string $property)
    {
        $property = Str::snake($property);
        $value = $this->properties[$property] ?? null;

        if (is_null($value)) {
            $defaults = $this->defaults();

            /** Check default value and return it or null */
            return $defaults[$property] ?? null;
        }

        $casts = $this->casts();
        if (isset($casts[$property]) && is_array($value)) {
            return $this->getCastValue($casts[$property], $value);
        }

        return $value;
    }

    /**
     * Get cast value of the property
     *
     * @param BaseObject $cast  - cast class
     * @param $value            - property value
     *
     * @return $this[]|$this
     */
    private function getCastValue(self $cast, $value): array|static
    {
        if (is_array($value)) {
            $elements = [];
            foreach ($value as $item) {
                $elements[] = $cast::make($item);
            }

            return $elements;
        }

        return $cast::make($value);
    }

    public function toArray(): array
    {
        $properties = [];

        foreach ($this->properties as $property => $value) {
            $value = $this->$property;

            if ($value instanceof self) {
                $properties[$property] = $value->toArray();
                continue;
            }

            if (is_object($value)) {
                $properties[$property] = (array) $value;
                continue;
            }

            $properties[$property] = $value;
        }

        return $properties;
    }

    public function toJson($options = 0): bool|string
    {
        $options = $options === 0 ? JSON_UNESCAPED_UNICODE : $options;

        return json_encode($this->toArray(), $options);
    }

    public static function make(array $properties): static
    {
        return new static($properties);
    }
}
