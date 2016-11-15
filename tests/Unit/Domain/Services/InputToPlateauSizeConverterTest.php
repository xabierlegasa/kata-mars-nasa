<?php

namespace Unit\Domain\Services;


use KataMarsNasa\Application\Validations\CoordinateValidator;
use KataMarsNasa\Domain\Entities\PlateauSize;
use KataMarsNasa\Domain\Services\InputToPlateauSizeConverter;

class InputToPlateauSizeConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var InputToPlateauSizeConverter */
    private $sut;

    /** @var CoordinateValidator */
    private $coordinateValidator;

    protected function setUp()
    {
        $this->coordinateValidator = $this->prophesize(CoordinateValidator::class);

        $this->sut = new InputToPlateauSizeConverter(
            $this->coordinateValidator->reveal()
        );
    }

    public function test_when_a_valid_input_is_given_should_return_the_correct_plateau_size_instance()
    {
        $input = '7 8';

        $this->coordinateValidator->validate($input)
            ->shouldBeCalled()
            ->willReturn(true);

        /** @var PlateauSize $plateauSize */
        $plateauSize = $this->sut->convert($input);

        $this->assertInstanceOf(PlateauSize::class, $plateauSize);
        $this->assertEquals(7, $plateauSize->x());
        $this->assertEquals(8, $plateauSize->y());
    }

    public function test_when_invalid_input_is_given_should_throw_an_exception()
    {
        $input = '0 7';

        $this->coordinateValidator->validate($input)
            ->shouldBeCalled()
            ->willReturn(false);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('First line is invalid. Check plateau coordinates.');

        $this->sut->convert($input);
    }
}
