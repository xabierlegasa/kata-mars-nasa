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

    /** @var int */
    private $nextMovement = 0;

    /**
     * Rover constructor.
     * @param Position $position
     * @param RoverMovements $movements
     */
    public function __construct(Position $position, RoverMovements $movements)
    {
        $this->position = $position;
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

    /**
     * @return bool
     */
    public function hasMovementsToDo()
    {
        return $this->nextMovement < $this->totalPlanedMovements();
    }

    /**
     * @return int
     */
    private function totalPlanedMovements()
    {
        return count($this->movements);
    }

    /**
     * @return Coordinate|void
     * @throws \Exception
     */
    public function nextMovementPosition()
    {
        if (!$this->hasMovementsToDo()) {
            throw new \Exception('Rover can not calculate next movement position, because there are no more moves');
        }

        /** @var Movement $nextMovement */
        $nextMovement = $this->movements->getMovement($this->nextMovement);

        /** @var Position $nextPosition */
        $nextPosition = $this->getPositionForNextMovement($this->position, $nextMovement);

        return $nextPosition;
    }

    private function getPositionForNextMovement(Position $position, Movement $movement)
    {
        $coordinate = Coordinate::calculateNextCoordinate($position, $movement);
        $direction = Direction::calculateNextDirection($position->direction(), $movement);

        return new Position($coordinate, $direction);
    }
}
