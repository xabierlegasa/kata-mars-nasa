<?php

namespace Unit\Domain\Services;


use KataMarsNasa\Application\Validations\InitialValidator;
use KataMarsNasa\Application\Validations\PlanOverlappingValidator;
use KataMarsNasa\Domain\Entities\Coordinate;
use KataMarsNasa\Domain\Entities\Movement;
use KataMarsNasa\Domain\Entities\Plan;
use KataMarsNasa\Domain\Entities\PlateauSize;
use KataMarsNasa\Domain\Entities\Position;
use KataMarsNasa\Domain\Entities\RoverMovements;
use KataMarsNasa\Domain\Services\InputToPlanTransformer;
use KataMarsNasa\Domain\Services\InputToPlateauSizeConverter;
use KataMarsNasa\Domain\Services\InputToRoverMovementsConverter;
use KataMarsNasa\Domain\Services\InputToRoversPositionConverter;
use Prophecy\Argument;
use Prophecy\Exception\Exception;

class InputToPlanTransformerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  InputToPlanTransformer */
    private $sut;

    /** @var InitialValidator */
    private $initialValidator;

    /** @var PlanOverlappingValidator */
    private $planOverlappingValidator;

    /** @var InputToPlateauSizeConverter */
    private $inputToPlateauSizeConverter;

    /** @var InputToRoversPositionConverter */
    private $inputToRoversPositionConverter;

    /** @var  InputToRoverMovementsConverter */
    private $inputToRoverMovementsConverter;

    public function setUp()
    {
        $this->initialValidator = $this->prophesize(InitialValidator::class);
        $this->planOverlappingValidator = $this->prophesize(PlanOverlappingValidator::class);
        $this->inputToPlateauSizeConverter = $this->prophesize(InputToPlateauSizeConverter::class);
        $this->inputToRoversPositionConverter = $this->prophesize(InputToRoversPositionConverter::class);
        $this->inputToRoverMovementsConverter = $this->prophesize(InputToRoverMovementsConverter::class);

        $this->sut = new InputToPlanTransformer(
            $this->initialValidator->reveal(),
            $this->planOverlappingValidator->reveal(),
            $this->inputToPlateauSizeConverter->reveal(),
            $this->inputToRoversPositionConverter->reveal(),
            $this->inputToRoverMovementsConverter->reveal()
        );
    }

    public function test_when_correct_input_is_given_should_create_correct_plan()
    {
        $input = [
            '5 6',
            '1 2 N',
            'RLM'
        ];
        $this->initialValidator->validate($input)
            ->shouldBeCalled()
            ->willReturn(true);

        $this->planOverlappingValidator->validate(Argument::any())
            ->shouldBeCalled()
            ->willReturn(true);

        $plateauSize = new PlateauSize(5, 6);
        $this->inputToPlateauSizeConverter->convert('5 6')
            ->shouldBeCalled()
            ->willReturn($plateauSize);

        $this->inputToRoversPositionConverter->convert('1 2 N', $plateauSize)->shouldBeCalled()
            ->willReturn(new Position(new Coordinate(1, 2), 'N'));
        $this->inputToRoverMovementsConverter->convert('RLM')->shouldBeCalled()
            ->willReturn(new RoverMovements([new Movement('R'), new Movement('L'), new Movement('M')]));

        /** @var Plan $plan */
        $plan = $this->sut->transform($input);

        $this->assertEquals(5, $plan->plateauSize()->x());
        $this->assertEquals(6, $plan->plateauSize()->y());
        $this->assertEquals(1, $plan->numberOfRovers());
    }


    public function test_when_rover_overlap_should_throw_an_exception()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('exception message');

        $input = [
            '5 6',
            '1 2 N',
            'RLM'
        ];
        $this->initialValidator->validate($input)
            ->shouldBeCalled()
            ->willReturn(true);

        $this->planOverlappingValidator->validate(Argument::any())
            ->shouldBeCalled()
            ->willThrow(new \Exception('exception message'));

        $plateauSize = new PlateauSize(5, 6);
        $this->inputToPlateauSizeConverter->convert('5 6')
            ->shouldBeCalled()
            ->willReturn($plateauSize);

        $this->inputToRoversPositionConverter->convert('1 2 N', $plateauSize)->shouldBeCalled()
            ->willReturn(new Position(new Coordinate(1, 2), 'N'));
        $this->inputToRoverMovementsConverter->convert('RLM')->shouldBeCalled()
            ->willReturn(new RoverMovements([new Movement('R'), new Movement('L'), new Movement('M')]));

        $this->sut->transform($input);
    }
}

