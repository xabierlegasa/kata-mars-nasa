<?php

namespace KataMarsNasa\Domain\Entities;


class Rover
{
    /**
     * @var Position
     */
    private $position;
    /**
     * @var RoverMovements
     */
    private $movements;

    /**
     * Rover constructor.
     * @param Position $position
     * @param RoverMovements $movements
     */
    public function __construct(Position $position, RoverMovements $movements)
    {
        $this->roversPosition = $position;
        $this->movements = $movements;
    }

    /**
     * @return RoverMovements
     */
    public function movements()
    {
        return $this->movements;
    }

    /**
     * @return Position
     */
    public function position()
    {
        return $this->position;
    }
}
