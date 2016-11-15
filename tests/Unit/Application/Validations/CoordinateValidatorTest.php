<?php

namespace Unit\Application\Validations;


use KataMarsNasa\Application\Validations\CoordinateValidator;

class CoordinateValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param bool $expectedIsValid
     * @param string $input
     *
     * @dataProvider inputProvider
     */
    public function test_coordinates_validity_is_checked_correctly(
        $expectedIsValid,
        $input
    ) {
        $coordinateValidator = new CoordinateValidator();
        $result = $coordinateValidator->validate($input);

        $this->assertEquals($expectedIsValid, $result);

    }

    public static function inputProvider()
    {
        return [
            [true, '7 7'],
            [true, '1 1'],
            [true, '1 7'],
            [false, '0 0'],
            [false, '0 7'],
            [false, '7 0'],
            [false, 'foo'],
            [false, 'foo 7'],
            [false, '7 foo'],
            [false, '7'],
            [false, '0'],
            [false, ''],
            [false, '1.1 7'],
            [false, '0000 0000'],
        ];
    }
}
