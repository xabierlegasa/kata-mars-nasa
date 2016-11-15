<?php

namespace Unit\Application\Validations;


use KataMarsNasa\Application\Validations\RoversMovementsValidator;

class RoversMovementsValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param bool $expectedIsValid
     * @param string $input
     *
     * @dataProvider inputProvider
     */
    public function test_rovers_movements_are_validated_correctly(
        $expectedIsValid,
        $input
    ) {
        $validator = new RoversMovementsValidator();
        $result = $validator->validate($input);

        $this->assertEquals($expectedIsValid, $result);
    }

    public static function inputProvider()
    {
        return [
            [true, 'MMRMMRMRRM'],
            [true, 'LMLMLMLMM'],
            [true, 'LMR'],
            [true, 'LLLLLL'],
            [true, 'RRRRR'],
            [true, 'MMMM'],
            [true, 'MMMM'],
            [false, ''],
            [false, ' '],
            [false, 'RMRX'],
            [false, 'FOO'],
            [false, 'RML RML'],
            [false, '7 7'],
            [false, '123'],
            [false, '0'],
        ];
    }
}
