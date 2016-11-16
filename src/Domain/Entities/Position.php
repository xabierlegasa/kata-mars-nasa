<?php

namespace KataMarsNasa\Domain\Entities;


class Position
{
    /** @var Coordinate */
    private $coordinate;

    /**
     * Can be one of the constants defined in Position class
     * @var string
     */
    private $direction;

    /**
     * Position constructor.
     * @param Coordinate $coordinate
     * @param string $direction
     */
    public function __construct(Coordinate $coordinate, $direction)
    {
        $this->coordinate = $coordinate;
        $this->direction = $direction;
    }

    /**
     * @return int
     */
    public function x()
    {
        return $this->coordinate->x();
    }

    /**
     * @return int
     */
    public function y()
    {
        return $this->coordinate->y();
    }

    /**
     * @return string
     */
    public function direction()
    {
        return $this->direction;
    }

    public function coordinate()
    {
        return $this->coordinate;
    }
}
