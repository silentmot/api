<?php

namespace ArrayKeysCaseTransform\Transformer;

abstract class AbstractTransformer
{

    public function transform(array $values) : array
    {
        $arrayFormatted = [];

        foreach ($values as $key => $value) {
            if (\is_array($value)) {
                $value = $this->transform($value);
            }

            $keyFormatted = \is_string($key) ? $this->format($key) : $key;

            $arrayFormatted[$keyFormatted] = $value;
        }

        return $arrayFormatted;
    }

    abstract protected function format(string $key) : string;
}
