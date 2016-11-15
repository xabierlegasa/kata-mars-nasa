<?php

namespace Unit\Application\Validations;


use KataMarsNasa\Application\Validations\InitialValidator;

class InitialValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param bool $expectedIsValid
     * @param string $input
     *
     * @dataProvider inputProvider
     */
    public function test_number_of_lines_is_validated_correctly(
        $expectedIsValid,
        $input
    ) {
        $validator = new InitialValidator();
        $result = $validator->validate($input);

        $this->assertEquals($expectedIsValid, $result);
    }

    public static function inputProvider()
    {
        return [
            [true, ['one single line']],
            [false, ['foo', 'bar']],
            [true, ['foo', 'bar', 'foobar']],
            [false, ['foo', 'bar', 'foobar', 'barfoo']],
            [true, ['foo', 'bar', 'foobar', 'barfoo', 'foo']],
            [false, ['foo', 'bar', 'foobar', 'barfoo', 'foo', 'false']]
        ];
    }
}
