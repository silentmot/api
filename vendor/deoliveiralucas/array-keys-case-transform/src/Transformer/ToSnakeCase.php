<?php

namespace ArrayKeysCaseTransform\Transformer;

use ICanBoogie\Inflector;

class ToSnakeCase extends AbstractTransformer
{

    protected function format(string $key): string
    {
        return Inflector::get()->underscore($key);
    }
}
