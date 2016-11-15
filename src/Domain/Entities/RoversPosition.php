<?php

namespace KataMarsNasa\Domain\Entities;


class RoversPosition
{
    const DIRECTION_NORTH = 'N';
    const DIRECTION_SOUTH = 'S';
    const DIRECTION_EAST = 'E';
    const DIRECTION_WEST = 'W';

    /**
     * @var int
     */
    private $x;
    /**
     * @var int
     */
    private $y;
    /**
     * Can be one of the constants defined in RoversPosition class
     * @var string
     */
    private $direction;

    /**
     * RoversPosition constructor.
     * @param int $x
     * @param int $y
     * @param string $direction
     */
    public function __construct($x, $y, $direction)
    {
        $this->x = $x;
        $this->y = $y;
        $this->direction = $direction;
    }

    /**
     * @return int
     */
    public function x()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function y()
    {
        return $this->y;
    }

    /**
     * @return string
     */
    public function direction()
    {
        return $this->direction;
    }
}
