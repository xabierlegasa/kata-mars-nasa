<?php

namespace Unit\Domain\Services;

use KataMarsNasa\Application\Validations\RoversMovementsValidator;
use KataMarsNasa\Domain\Entities\Movement;
use KataMarsNasa\Domain\Entities\RoverMovements;
use KataMarsNasa\Domain\Services\InputToRoverMovementsConverter;

class InputToRoverMovementsConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var InputToRoverMovementsConverter */
    private $sut;

    /** @var  RoversMovementsValidator */
    private $roversMovementsValidator;

    protected function setUp()
    {
        $this->roversMovementsValidator = $this->prophesize(RoversMovementsValidator::class);

        $this->sut = new InputToRoverMovementsConverter(
            $this->roversMovementsValidator->reveal()
        );
    }

    public function test_when_valid_rover_movements_input_is_given_should_return_a_rovers_movements_instance()
    {
        $input = 'RLMR';

        $this->roversMovementsValidator->validate($input)
            ->shouldBeCalled()
            ->willReturn(true);

        /** @var RoverMovements $result */
        $roverMovements = $this->sut->convert($input);

        $this->assertInstanceOf(RoverMovements::class, $roverMovements);
        $this->assertEquals(4, count($roverMovements->movements()));

        $this->assertEquals(Movement::RIGHT, $roverMovements->movements()[0]->movement());
        $this->assertEquals(Movement::LEFT, $roverMovements->movements()[1]->movement());
        $this->assertEquals(Movement::MOVE, $roverMovements->movements()[2]->movement());
        $this->assertEquals(Movement::RIGHT, $roverMovements->movements()[3]->movement());
    }

    public function test_when_invalid_rover_movements_input_is_given_should_throw_an_exception()
    {
        $input = 'RLM And something invalid';

        $this->roversMovementsValidator->validate($input)
            ->shouldBeCalled()
            ->willReturn(false);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Rovers movement input is invalid');

        $this->sut->convert($input);

        $this->assertEquals(1, 1);
    }
}
