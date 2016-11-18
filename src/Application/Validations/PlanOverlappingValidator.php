<?php

namespace KataMarsNasa\Application\Validations;


use KataMarsNasa\Domain\Entities\Coordinate;
use KataMarsNasa\Domain\Entities\Plan;
use KataMarsNasa\Domain\Entities\Rover;
use KataMarsNasa\Domain\Exceptions\InvalidMissionException;

class PlanOverlappingValidator
{
    /**
     * @param Plan $plan
     * @throws InvalidMissionException
     */
    public function validate(Plan $plan)
    {
        $coordinatesWithRovers = [];

        /** @var Rover $rover */
        foreach ($plan->rovers() as $roverNum => $rover) {
            $roverCoordinate = $rover->position()->coordinate();
            $overlapsWithRoverNumber = $this->thereIsARoverInCoordinate($roverCoordinate, $coordinatesWithRovers);
            if (0 !== $overlapsWithRoverNumber) {
                throw new InvalidMissionException('There are two rovers in the same grid: Rover ' . $roverNum . ' overlaps with rover number ' . $overlapsWithRoverNumber);
            }
            $coordinatesWithRovers[] = $roverCoordinate;
        }
    }

    /**
     * @param Coordinate $coordinate
     * @param array $coordinatesWithRovers
     * @return int Returns the rover number which the given coordinates overlaps, or 0 if ther is no overlapping
     */
    private function thereIsARoverInCoordinate(Coordinate $coordinate, array $coordinatesWithRovers)
    {
        /** @var Coordinate $fullCoordinate */
        foreach ($coordinatesWithRovers as $roverNum => $fullCoordinate) {
            if ($coordinate->x() === $fullCoordinate->x() && $coordinate->y() === $fullCoordinate->y()) {
                return $roverNum;
            }
        }

        return 0;
    }
}
