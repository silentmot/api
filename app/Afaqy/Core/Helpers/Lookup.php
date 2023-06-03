<?php

namespace Afaqy\Core\Helpers;

class Lookup
{
    /**
     * Get all class constants and convert them to array.
     *
     * @return array
     */
    public static function toArray(): array
    {
        $class = new \ReflectionClass(new static);

        return array_change_key_case($class->getConstants());
    }

    /**
     * Get all class constants and convert them to reverse array.
     *
     * @return array
     */
    public static function toReverseArray(): array
    {
        return array_flip(static::toArray());
    }

    /**
     * Return only keys.
     *
     * @param  array  $keys
     * @return array
     */
    public static function only(array $keys): array
    {
        $keys = array_flip($keys);

        return array_intersect_key(static::toArray(), $keys);
    }

    /**
     * Return only keys reversed.
     *
     * @param  array  $keys
     * @return array
     */
    public static function onlyReversed(array $keys): array
    {
        return array_flip(static::only($keys));
    }

    /**
     * Return all keys except given keys.
     *
     * @param  array  $keys
     * @return array
     */
    public static function except(array $keys): array
    {
        $keys = array_flip($keys);

        return array_diff_key(static::toArray(), $keys);
    }

    /**
     * Return all keys except given keys reversed.
     *
     * @param  array  $keys
     * @return array
     */
    public static function exceptReversed(array $keys): array
    {
        return array_flip(static::except($keys));
    }
}
