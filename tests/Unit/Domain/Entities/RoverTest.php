<?php

namespace Unit\Domain\Entities;


use KataMarsNasa\Domain\Entities\Coordinate;
use KataMarsNasa\Domain\Entities\Direction;
use KataMarsNasa\Domain\Entities\Movement;
use KataMarsNasa\Domain\Entities\Position;
use KataMarsNasa\Domain\Entities\Rover;
use KataMarsNasa\Domain\Entities\RoverMovements;

class RoverTest extends \PHPUnit_Framework_TestCase
{
    public function test_rover_calculats_next_movement_correctly_and_can_navigate_correctly()
    {
        $rover = new Rover(new Position(new Coordinate(4, 4), Direction::NORTH),
                                                // x y direction
            new RoverMovements([                // 4 4 N
                new Movement(Movement::MOVE),   // 4 5 N
                new Movement(Movement::RIGHT),  // 4 5 E
                new Movement(Movement::MOVE),   // 5 5 E
                new Movement(Movement::RIGHT),  // 5 5 S
                new Movement(Movement::MOVE),   // 5 4 S
                new Movement(Movement::MOVE),   // 5 3 S
                new Movement(Movement::RIGHT),  // 5 3 W
                new Movement(Movement::MOVE),   // 4 3 W
                new Movement(Movement::RIGHT),  // 4 3 N
                new Movement(Movement::LEFT),   // 4 3 W
            ]));

        $this->assertEquals(new Position(new Coordinate(4, 4), 'N'), $rover->position());



        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(4, 5), 'N'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(4, 5), 'N'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(4, 5), 'E'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(4, 5), 'E'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(5, 5), 'E'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(5, 5), 'E'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(5, 5), 'S'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(5, 5), 'S'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(5, 4), 'S'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(5, 4), 'S'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(5, 3), 'S'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(5, 3), 'S'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(5, 3), 'W'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(5, 3), 'W'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(4, 3), 'W'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(4, 3), 'W'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(4, 3), 'N'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(4, 3), 'N'), $rover->position());

        $nextPosition = $rover->nextMovementPosition();
        $this->assertEquals(new Position(new Coordinate(4, 3), 'W'), $nextPosition);
        $rover->doNextMovement();
        $this->assertEquals(new Position(new Coordinate(4, 3), 'W'), $rover->position());
    }
}
