<?php

namespace Unit\Application\Validations;


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
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Input cant not be empty');

        $this->sut->validate('');
    }

    

}
