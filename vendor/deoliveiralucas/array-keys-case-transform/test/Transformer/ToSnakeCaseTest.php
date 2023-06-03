<?php

namespace ArrayKeysCaseTransformTest\Transformer;

use ArrayKeysCaseTransform\Transformer\ToSnakeCase;
use PHPUnit\Framework\TestCase;

class ToSnakeCaseTest extends TestCase
{

    public function testTransformShouldWork() : void
    {
        $arrayToBeTested = [
            'firstItem'   => 'First Item',
            'second item' => 'Second Item',
            'third-item'  => 'Third Item',
            'fourth_item' => 'Fourth Item',
            'arrayValueItem'  => ['Array Value Item'],
        ];

        $arrayExpected = [
            'first_item'  => 'First Item',
            'second_item' => 'Second Item',
            'third_item'  => 'Third Item',
            'fourth_item' => 'Fourth Item',
            'array_value_item'  => ['Array Value Item'],
        ];

        $result = (new ToSnakeCase())->transform($arrayToBeTested);

        self::assertEquals($arrayExpected, $result);
    }
}
