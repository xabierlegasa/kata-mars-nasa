<?php

namespace Unit\Domain\Entities;


use KataMarsNasa\Domain\Entities\Coordinate;
use KataMarsNasa\Domain\Entities\Mission;
use KataMarsNasa\Domain\Entities\Movement;
use KataMarsNasa\Domain\Entities\Plan;
use KataMarsNasa\Domain\Entities\PlateauSize;
use KataMarsNasa\Domain\Entities\Position;
use KataMarsNasa\Domain\Entities\Rover;
use KataMarsNasa\Domain\Entities\RoverMovements;

class MissionTest extends \PHPUnit_Framework_TestCase
{
    public function test_a_valid_plan_can_be_simulated()
    {
        $plan = new Plan(new PlateauSize(5, 5));
        $plan->addRover(
            new Rover(
                new Position(new Coordinate(1, 2), 'N'),
                new RoverMovements(
                    [
                        new Movement('L'),
                        new Movement('M'),
                        new Movement('L'),
                        new Movement('M'),
                        new Movement('L'),
                        new Movement('M'),
                        new Movement('L'),
                        new Movement('M'),
                        new Movement('M'),
                    ]
                )
            )
        );

        $plan->addRover(
            new Rover(
                new Position(new Coordinate(3, 3), 'E'),
                new RoverMovements(
                    [
                        new Movement('M'),
                        new Movement('M'),
                        new Movement('R'),
                        new Movement('M'),
                        new Movement('M'),
                        new Movement('R'),
                        new Movement('M'),
                        new Movement('R'),
                        new Movement('R'),
                        new Movement('M'),
                    ]
                )
            )
        );


        $mission = new Mission($plan);
        $mission->simulatePlan();

        $expectedOutput = <<<XML
1 3 N
5 1 E
XML;
        $this->assertEquals($expectedOutput, $mission->generateOutput());
    }
}
