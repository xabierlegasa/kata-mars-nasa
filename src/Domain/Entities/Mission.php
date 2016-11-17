<?php

namespace KataMarsNasa\Domain\Entities;


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

    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function simulatePlan()
    {
        $rovers = $this->plan->rovers();

        /** @var Rover $rover */
        foreach ($rovers as $key => $rover) {
            while ($rover->hasMovementsToDo()) {

                /** @var Position $position */
                $position = $rover->nextMovementPosition();

//                if (!$position->isInsidePlateau($this->plan->plateauSize())) {
//                    $roverNumber = $key + 1;
//                    throw new InvalidMissionException('Rover number ' . $roverNumber . ' will leave the plateau. Abort!');
//                }

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
        foreach($this->plan->rovers() as $rover) {
            if (!empty($output)) {
                $output .= "\n";
            }

            $output .= $rover->outputPosition();
        }

        return $output;
    }
}
