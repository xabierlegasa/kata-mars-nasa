<?php

namespace Unit\Domain\UseCases;


use KataMarsNasa\Domain\Entities\Mission;
use KataMarsNasa\Domain\Entities\Movement;
use KataMarsNasa\Domain\Entities\Plan;
use KataMarsNasa\Domain\Entities\PlateauSize;
use KataMarsNasa\Domain\Entities\Position;
use KataMarsNasa\Domain\Entities\Rover;
use KataMarsNasa\Domain\Entities\RoverMovements;
use KataMarsNasa\Domain\Services\InputToPlanTransformer;
use KataMarsNasa\Domain\UseCases\ExploreMarsUseCase;

class ExploreMarsUseCaseTest extends \PHPUnit_Framework_TestCase
{
    /** @var ExploreMarsUseCase */
    private $sut;

    /** @var InputToPlanTransformer */
    private $inputToPlanTransformer;

    public function setUp()
    {
        $this->inputToPlanTransformer = $this->prophesize(InputToPlanTransformer::class);
        $this->sut = new ExploreMarsUseCase(
            $this->inputToPlanTransformer->reveal()
        );
    }

    public function test_when_simulation_goes_fine_mission_status_is_correct()
    {
        $input = ['7 7', '3 4 N', 'RLM'];

        $dummyPlan = new Plan(new PlateauSize(7, 7));
        $dummyPlan->addRover(
            new Rover(
                new Position(3, 4, 'N'),
                new RoverMovements(
                    [
                        new Movement('R'),
                        new Movement('L'),
                        new Movement('M')
                    ]
                )
            )
        );

        $this->inputToPlanTransformer->transform($input)
            ->shouldBeCalled()
            ->willReturn($dummyPlan);

        /** @var Mission $mission */
        $mission = $this->sut->execute($input);
        $this->assertEquals('simulation success', $mission->state());
    }
}
