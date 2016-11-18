<?php

namespace KataMarsNasa\Domain\Entities;


use KataMarsNasa\Application\Validations\PlanOverlappingValidator;
use KataMarsNasa\Domain\Exceptions\InvalidMissionException;

class Mission
{
    const STATE_READY = 'ready';
    const STATE_SIMULATION_SUCCESS = 'simulation success';
    const STATE_SIMULATION_FAILED = 'simulation failed';
    const STATE_SUCCESS = 'success';
    const STATE_FAIlED = 'failed';

    /**
     * @var Plan
     */
    private $plan;

    /** @var string */
    private $state;

    /** @var PlanOverlappingValidator */
    private $PlanOverlappingValidator;

    /**
     * Mission constructor.
     * @param Plan $plan
     * @param PlanOverlappingValidator $planOverlappingValidator
     */
    public function __construct(Plan $plan, PlanOverlappingValidator $planOverlappingValidator)
    {
        $this->plan = $plan;
        $this->planOverlappingValidator = $planOverlappingValidator;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function simulatePlan()
    {
        $this->planOverlappingValidator->validate($this->plan);

        $rovers = $this->plan->rovers();

        /** @var Rover $rover */
        foreach ($rovers as $key => $rover) {
            while ($rover->hasMovementsToDo()) {

                /** @var Position $position */
                $position = $rover->nextMovementPosition();

                if (!$this->plan->plateau()->coordinatesAreInsidePlateau($position->coordinate())) {
                    $roverNumber = $key + 1;
                    throw new InvalidMissionException('Abort Mission! Rover number ' . $roverNumber
                        . ' would leave the plateau in movement number '
                        . $rover->nextMovementNumber()
                        . ' because grid ' . $position->x() . ',' . $position->y() . ' is out of the plateau');
                }

                $rover->doNextMovement();
            }
        }

        $this->state = self::STATE_SIMULATION_SUCCESS;
        return true;
    }

    public function state()
    {
        return $this->state;
    }

    public function generateOutput()
    {
        $output = '';

        /** @var Rover $rover */
        foreach ($this->plan->rovers() as $rover) {
            if (!empty($output)) {
                $output .= "\n";
            }

            $output .= $rover->outputPosition();
        }

        return $output;
    }
}
