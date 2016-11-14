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

//    public function test_if_input_lines_is_invalid_should_return_false()
//    {
//
//    }

    public function test_if_empty_input_is_given_should_return_false()
    {
        $result = $this->sut->validate([]);

        $this->assertInstanceOf(InputValidationResult::class, $result);
        $this->assertEquals('Input can not be empty', $result->reason());
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


    public static function coordinatesInputProvider()
    {
        return [
            [['7 7'], true, ''],
            [['something'], false, 'Invalid upper-right coordinates'],
            [['0 7'], false, 'Invalid upper-right coordinates'],
            [['7 0'], false, 'Invalid upper-right coordinates'],
            [['0 0'], false, 'Invalid upper-right coordinates'],
            [['7 2.2'], false, 'Invalid upper-right coordinates'],
            [['7 2,2'], false, 'Invalid upper-right coordinates'],
        ];
    }

//    public static function numberOfLinesInputProvider()
//    {
//        return [
//            ['7 7', true, ''],
//            ['7 7', false, 'Invalid number of lines'],
//
//        ];
//    }
}
