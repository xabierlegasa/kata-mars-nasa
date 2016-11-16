<?php

namespace KataMarsNasa\Domain\Entities;


class Coordinate
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * Position constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param Position $position
     * @param Movement $movement
     * @return Coordinate
     */
    public static function calculateNextCoordinate(Position $position, Movement $movement)
    {
        if ($movement->movement() === Movement::MOVE) {
            switch ($position->direction()) {
                case Direction::NORTH:
                    $coordinate = new Coordinate($position->x(), $position->y() + 1);
                    break;
                case Direction::EAST:
                    $coordinate = new Coordinate($position->x() + 1, $position->y());
                    break;
                case Direction::SOUTH:
                    $coordinate = new Coordinate($position->x(), $position->y() - 1);
                    break;
                case Direction::WEST:
                    $coordinate = new Coordinate($position->x() - 1, $position->y());
                    break;
            }
        } else {
            $coordinate = $position->coordinate();
        }

        return $coordinate;
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
}
