<?php

namespace ArrayKeysCaseTransformTest;

use ArrayKeysCaseTransform\ArrayKeys;
use ArrayKeysCaseTransform\Transformer\AbstractTransformer;
use PHPUnit\Framework\TestCase;

class ArrayKeysTest extends TestCase
{

    public function testToSnakeCaseCallShouldWork() : void
    {
        self::assertSame([], ArrayKeys::toSnakeCase([]));
    }

    public function testToCamelCaseCallShouldWork() : void
    {
        self::assertSame([], ArrayKeys::toCamelCase([]));
    }

    public function testTransformCallShouldWork() : void
    {
        $converter = new class extends AbstractTransformer {
            protected function format(string $key): string
            {
                return $key;
            }
        };

        self::assertSame([], ArrayKeys::transform($converter, []));
    }
}
