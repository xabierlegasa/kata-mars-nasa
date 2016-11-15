<?php

namespace KataMarsNasa\Domain\Entities;


class Plan
{
    /** @var PlateauSize  */
    private $plateauSize;

    /**@var array An array of Rover objects */
    private $rovers;

    /**
     * Plan constructor.
     * @param PlateauSize $plateauSize
     */
    public function __construct(PlateauSize $plateauSize)
    {
        $this->plateauSize = $plateauSize;
    }

    public function addRover(Rover $rover)
    {
        $this->rovers[] = $rover;
    }

    public function plateauSize()
    {
        return $this->plateauSize;
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
