<?php

namespace ArrayKeysCaseTransform;

use ArrayKeysCaseTransform\Transformer\AbstractTransformer;
use ArrayKeysCaseTransform\Transformer\ToCamelCase;
use ArrayKeysCaseTransform\Transformer\ToSnakeCase;

class ArrayKeys
{

    public static function toSnakeCase(array $values) : array
    {
        return static::transform(new ToSnakeCase(), $values);
    }

    public static function toCamelCase(array $values) : array
    {
        return static::transform(new ToCamelCase(), $values);
    }

    public static function transform(AbstractTransformer $transformer, array $values) : array
    {
        return $transformer->transform($values);
    }
}
