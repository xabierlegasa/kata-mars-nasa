<?php

namespace KataMarsNasa\Domain\Entities;


class Plan
{
    /** @var Plateau  */
    private $plateau;

    /**@var array An array of Rover objects */
    private $rovers;

    /**
     * Plan constructor.
     * @param Plateau $plateau
     */
    public function __construct(Plateau $plateau)
    {
        $this->plateau = $plateau;
    }

    public function addRover(Rover $rover)
    {
        $this->rovers[] = $rover;
    }

    public function plateauSize()
    {
        return $this->plateau->plateauSize();
    }

    public function rovers()
    {
        return $this->rovers;
    }

    public function numberOfRovers()
    {
        return count($this->rovers());
    }
}
