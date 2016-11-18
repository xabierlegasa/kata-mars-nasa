<?php

namespace Unit\Domain\Entities;


use KataMarsNasa\Application\Validations\PlanOverlappingValidator;
use KataMarsNasa\Domain\Entities\Coordinate;
use KataMarsNasa\Domain\Entities\Mission;
use KataMarsNasa\Domain\Entities\Movement;
use KataMarsNasa\Domain\Entities\Plan;
use KataMarsNasa\Domain\Entities\Plateau;
use KataMarsNasa\Domain\Entities\PlateauSize;
use KataMarsNasa\Domain\Entities\Position;
use KataMarsNasa\Domain\Entities\Rover;
use KataMarsNasa\Domain\Entities\RoverMovements;
use KataMarsNasa\Domain\Exceptions\InvalidMissionException;

class MissionTest extends \PHPUnit_Framework_TestCase
{
    public function test_a_valid_plan_can_be_simulated()
    {
        $plan = new Plan(new Plateau(new PlateauSize(5, 5)));
        $this->addRoverToPlan($plan, 1, 2, 'N', 'LMLMLMLMM');
        $this->addRoverToPlan($plan, 3, 3, 'E', 'MMRMMRMRRM');

        $mission = new Mission($plan, new PlanOverlappingValidator());
        $mission->simulatePlan();

        $expectedOutput = $this->buildExpectedOutput(
            [
                '1 3 N',
                '5 1 E',
            ]
        );
        $this->assertEquals($expectedOutput, $mission->generateOutput());
    }

    public function test_when_a_rover_is_leaving_the_plateau_should_throw_an_exception()
    {
        $this->expectException(InvalidMissionException::class);
        $this->expectExceptionMessage('Rover number 2 would leave the plateau in movement number 1 because grid -1,1 is out of the plateau');

        $plan = new Plan(new Plateau(new PlateauSize(5, 5)));
        $this->addRoverToPlan($plan, 1, 2, 'N', 'LMLMLMLMM');
        $this->addRoverToPlan($plan, 1, 1, 'W', 'MM');

        $mission = new Mission($plan, new PlanOverlappingValidator());
        $mission->simulatePlan();
    }

    public function test_when_rovers_overlap_each_other_on_initial_position_should_throw_correct_exception()
    {
        $this->expectException(InvalidMissionException::class);
        $this->expectExceptionMessage('There are two rovers in the same grid: Rover 2 overlaps with rover 1');

        $plan = new Plan(new Plateau(new PlateauSize(5, 5)));
        $this->addRoverToPlan($plan, 1, 2, 'N', 'LMLMLMLMM');
        $this->addRoverToPlan($plan, 1, 1, 'E', 'MM');
        $this->addRoverToPlan($plan, 1, 1, 'N', 'M');

        $mission = new Mission($plan, new PlanOverlappingValidator());
        $mission->simulatePlan();
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
