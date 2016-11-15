<?php

namespace Unit\Domain\Services;


use KataMarsNasa\Application\Validations\RoversPositionValidator;
use KataMarsNasa\Domain\Entities\PlateauSize;
use KataMarsNasa\Domain\Entities\Position;
use KataMarsNasa\Domain\Services\InputToRoversPositionConverter;

class InputToRoversPositionConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var InputToRoversPositionConverter */
    private $sut;

    /** @var  RoversPositionValidator */
    private $roversPositionValidator;

    protected function setUp()
    {
        $this->roversPositionValidator = $this->prophesize(RoversPositionValidator::class);

        $this->sut = new InputToRoversPositionConverter(
            $this->roversPositionValidator->reveal()
        );
    }

    public function test_when_correct_rover_position_input_is_given_shoul_return_a_rovert_position_instance()
    {
        $input = '3 4 N';
        $plateauSize = new PlateauSize(7, 7);

        $this->roversPositionValidator->validate($input, $plateauSize)
            ->shouldBeCalled()
            ->willReturn(true);

        /** @var Position $result */
        $roversPosition = $this->sut->convert($input, $plateauSize);

        $this->assertInstanceOf(Position::class, $roversPosition);
        $this->assertEquals(3, $roversPosition->x());
        $this->assertEquals(4, $roversPosition->y());
        $this->assertEquals('N', $roversPosition->direction());
    }


    public function test_when_invalid_input_is_given_should_throw_an_exception()
    {
        $input = '3 4 N';
        $plateauSize = new PlateauSize(7, 7);

        $this->roversPositionValidator->validate($input, $plateauSize)
            ->shouldBeCalled()
            ->willReturn(false);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Rovers position input is invalid');

        $this->sut->convert($input, $plateauSize);
    }
}
