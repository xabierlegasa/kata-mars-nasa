<?php

namespace Unit\Application\Validations;


use KataMarsNasa\Application\Validations\RoversPositionValidator;
use KataMarsNasa\Domain\Entities\PlateauSize;

class RoversPositionValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param bool $expectedIsValid
     * @param string $input
     *
     * @dataProvider inputProvider
     */
    public function test_rovers_position_is_validated_correctly(
        $expectedIsValid,
        $input
    ) {
        $plateauSize = new PlateauSize(7, 7);

        $validator = new RoversPositionValidator();
        $result = $validator->validate($input, $plateauSize);

        $this->assertEquals($expectedIsValid, $result);
    }

    public static function inputProvider()
    {
        return [
            [true, '5 5 N'],
            [true, '5 5 S'],
            [true, '5 5 E'],
            [true, '5 5 W'],
            [true, '7 7 W'],
            [false, '0 5 N'],
            [false, '5 0 N'],
            [false, '0 0 N'],
            [false, '5 5 X'],
            [false, '8 7 N'],
            [false, '8 8 X'],
            [false, '7 7 W '],
            [false, ' 7 7 W'],
            [false, 'foo'],
            [false, ''],
            [false, '7'],
            [false, '7 7'],
            [false, 'W'],
        ];
    }
}
