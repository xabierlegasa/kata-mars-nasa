<?php

namespace Unit\Application\Validations;


use KataMarsNasa\Application\Validations\InputValidationResult;
use KataMarsNasa\Application\Validations\InputValidator;

class InputValidatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  InputValidator */
    private $sut;

    protected function setUp()
    {
        $this->sut = new InputValidator();
    }

    /**
     * @param string $input
     *
     * @dataProvider validInputProvider
     */
    public function test_if_valid_plan_is_given_should_say_is_valid(
        $input
    ) {
        $result = $this->sut->validate($input);

        $this->assertInstanceOf(InputValidationResult::class, $result);
        $this->assertTrue($result->isValid());
    }


    /**
     * @param string $input
     * @param bool $expectedIsValid
     * @param string $reason
     *
     * @dataProvider coordinatesInputProvider
     */
    public function test_if_first_line_is_not_a_valid_upper_right_coordinates_should_return_false(
        $input,
        $expectedIsValid,
        $reason
    ) {
        $result = $this->sut->validate($input);

        $this->assertInstanceOf(InputValidationResult::class, $result);
        $this->assertEquals($expectedIsValid, $result->isValid());
        $this->assertEquals($reason, $result->reason());
    }

    /**
     * @param string $input
     * @param bool $expectedIsValid
     * @param string $reason
     *
     * @dataProvider numberOfLinesInputProvider
     */
    public function test_if_input_number_of_lines_is_invalid_should_return_false(
        $input,
        $expectedIsValid,
        $reason
    ) {
        $result = $this->sut->validate($input);

        $this->assertInstanceOf(InputValidationResult::class, $result);
        $this->assertEquals($expectedIsValid, $result->isValid());
        $this->assertEquals($reason, $result->reason());
    }

    /**
     * @param bool $expectedIsValid
     * @param string $input
     * @param string $reason
     *
     * @dataProvider roversPositionInputProvider
     */
    public function test_when_rovers_position_is_invalid_should_say_is_an_invalid_plan(
        $expectedIsValid,
        $input,
        $reason
    ) {
        $result = $this->sut->validate($input);

        $this->assertInstanceOf(InputValidationResult::class, $result);
        $this->assertEquals($expectedIsValid, $result->isValid());
        $this->assertEquals($reason, $result->reason());
    }

    public static function roversPositionInputProvider()
    {
        return [
            [true, ['7 7', '1 2 N', 'LMLMLMLMM'], ''],
            [true, ['7 7', '7 7 N', 'LMLMLMLMM'], ''],
            [false, ['7 7', '1 35 N', 'LMLMLMLMM'], 'Rovers position at line 2 is invalid'],
            [false, ['7 7', '8 5 N', 'LMLMLMLMM'], 'Rovers position at line 2 is invalid'],
            [false, ['7 7', '4 5 N', 'LMLMLMLMM', '1 35 N', 'LMLMLMLMM'], 'Rovers position at line 4 is invalid'],
            [false, ['7 7', '4 5 N', 'LMLMLMLMM', '7 7 X', 'LMLMLMLMM'], 'Rovers position at line 4 is invalid'],
        ];
    }


    public static function coordinatesInputProvider()
    {
        return [
            [['7 7'], true, ''],
            [['07 7'], true, ''],
            [['something'], false, 'Invalid upper-right coordinates'],
            [['0 7'], false, 'Invalid upper-right coordinates'],
            [['7 0'], false, 'Invalid upper-right coordinates'],
            [['0 0'], false, 'Invalid upper-right coordinates'],
            [['7 2.2'], false, 'Invalid upper-right coordinates'],
            [['7 2,2'], false, 'Invalid upper-right coordinates'],
        ];
    }

    public static function numberOfLinesInputProvider()
    {
        return [
            [['7 7', '1 2 N', 'LMLMLMLMM'], true, ''],
            [['7 7', '1 2 N'], false, 'Number of lines is incorrect'],
            [['7 7', '1 2 N', 'LMLMLMLMM', '33 E'], false, 'Number of lines is incorrect'],
        ];
    }

    public static function validInputProvider()
    {
        return [
            [['7 7', '1 2 N', 'LMLMLMLMM']],
            [['7 7', '1 2 N', 'LMLMLMLMM', '3 3 E', 'MMRMMRMRRM']],
            [['9 3', '1 2 N', 'LMLMLMLMM', '3 3 E', 'MMRMMRMRRM', '5 3 N', 'MMRMM']],
        ];
    }


}
