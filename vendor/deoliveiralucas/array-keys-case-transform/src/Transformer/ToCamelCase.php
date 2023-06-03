<?php

namespace ArrayKeysCaseTransform\Transformer;

use ICanBoogie\Inflector;

class ToCamelCase extends AbstractTransformer
{

    protected function format(string $key): string
    {
        return Inflector::get()->camelize(\str_replace(' ', '_', $key), Inflector::DEFAULT_LOCALE);
    }
}
