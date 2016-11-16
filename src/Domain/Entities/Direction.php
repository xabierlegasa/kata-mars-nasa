<?php

namespace KataMarsNasa\Domain\Entities;


class Direction
{
    const NORTH = 'N';
    const SOUTH = 'S';
    const EAST = 'E';
    const WEST = 'W';

    /**
     * @param string $currentDirection
     * @param Movement $movement
     * @return mixed
     */
    public static function calculateNextDirection($currentDirection, Movement $movement)
    {
        if ($movement->movement() === Movement::RIGHT) {
            switch ($currentDirection) {
                case self::NORTH:
                    return self::EAST;
                case self::EAST:
                    return self::SOUTH;
                case self::SOUTH:
                    return self::WEST;
                case self::WEST:
                    return self::NORTH;
            }
        }

        if ($movement->movement() === Movement::LEFT) {
            switch ($currentDirection) {
                case self::NORTH:
                    return self::WEST;
                case self::WEST:
                    return self::SOUTH;
                case self::SOUTH:
                    return self::EAST;
                case self::EAST:
                    return self::NORTH;
            }
        }

        return $currentDirection;
    }
}
