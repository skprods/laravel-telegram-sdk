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
     * @param array|string $cast    - cast class or array of string with cast
     * @param $value                - property value
     *
     * @return $this[]|$this
     */
    private function getCastValue(array|string $cast, $value): array|self
    {
        if (is_array($cast)) {
            /** @var BaseObject $castClass */
            $castClass = array_pop($cast);

            $elements = [];
            foreach ($value as $item) {
                $elements[] = $castClass::make($item);
            }

            return $elements;
        }

        /** @var BaseObject $cast */
        return $cast::make($value);
    }

    public function has(string|array $property): bool
    {
        $keys = is_array($property) ? $property : func_get_args();

        foreach ($keys as $value) {
            if (!array_key_exists($value, $this->properties)) {
                return false;
            }
        }

        return true;
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

            if (is_array($value)) {
                foreach ($value as $item) {
                    if ($item instanceof self) {
                        $properties[$property][] = $item->toArray();
                        continue;
                    }

                    if (is_object($item)) {
                        $properties[$property][] = (array) $item;
                        continue;
                    }

                    $properties[$property][] = $value;
                }

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
