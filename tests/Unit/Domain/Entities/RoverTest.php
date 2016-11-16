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
    public function test_rover_calculates_next_movements_coordinates_correctly()
    {
        $rover = new Rover(new Position(new Coordinate(4, 4), Direction::NORTH),
            new RoverMovements([
                new Movement(Movement::MOVE),   // 4 5 N
                new Movement(Movement::RIGHT),  // 4 5 R
                new Movement(Movement::MOVE)    // 4 6 R
            ]));
        /** @var Position $position */
        $position = $rover->nextMovementPosition();

        $this->assertInstanceOf(Position::class, $position);
        $this->assertEquals(4, $position->x());
        $this->assertEquals(5, $position->y());
        $this->assertEquals('N', $position->direction());

        


    }
}
