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

    public function test_when_empty_input_is_given_should_throw_an_exception()
    {
        $result = $this->sut->validate('');

        $this->assertInstanceOf(InputValidationResult::class, $result);
        $this->assertEquals('Input can not be empty', $result->reason());
    }

    /**
     * @param string $input
     * @param bool $expectedIsValid
     * @param string $reason
     *
     * @dataProvider coordinatesInputProviders
     */
    public function test_if_first_line_is_not_a_valid_upper_right_coordinates_throw_an_exception(
        $input,
        $expectedIsValid,
        $reason
    ) {
        $result = $this->sut->validate($input);

        $this->assertInstanceOf(InputValidationResult::class, $result);
        $this->assertEquals($expectedIsValid, $result->isValid());
        $this->assertEquals($reason, $result->reason());
    }


    public static function coordinatesInputProviders()
    {
        return [
            ['5 5', true, ''],
            ['something', false, 'Invalid upper-right coordinates']
        ];
    }
}
