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
        $this->addRoverToPlan($plan, 1, 2, 'N', 'LMLMLMLMM');
        $this->addRoverToPlan($plan, 3, 3, 'E', 'MMRMMRMRRM');

        $mission = new Mission($plan);
        $mission->simulatePlan();

        $expectedOutput = $this->buildExpectedOutput(
            [
                '1 3 N',
                '5 1 E',
            ]
        );
        $this->assertEquals($expectedOutput, $mission->generateOutput());
    }

    private function addRoverToPlan($plan, $x, $y, $direction, $movements)
    {
        foreach (str_split($movements) as $move) {
            $moves[] = new Movement($move);
        }
        $plan->addRover(
            new Rover(
                new Position(new Coordinate($x, $y), $direction),
                new RoverMovements(
                    $moves
                )
            )
        );
    }

    /**
     * @param array $lines
     * @return string
     */
    private function buildExpectedOutput(array $lines)
    {
        $output = '';
        foreach ($lines as $line) {
            if (!empty($output)) {
                $output .= "\n";
            }
            $output .= $line;
        }

        return $output;
    }
}
