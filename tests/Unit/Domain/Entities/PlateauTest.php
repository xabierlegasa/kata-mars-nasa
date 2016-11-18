<?php

namespace Unit\Domain\Entities;


use KataMarsNasa\Domain\Entities\Coordinate;
use KataMarsNasa\Domain\Entities\Plateau;
use KataMarsNasa\Domain\Entities\PlateauSize;

class PlateauTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param bool $coordinateIsInsideExpected
     * @param int $plateauX
     * @param int $plateauY
     * @param array $coordinates
     *
     * @dataProvider inputProvider
     */
    public function test_plateau_calculates_right_if_a_coorinate_is_inside_the_plateau_or_not(
        $coordinateIsInsideExpected,
        $plateauX,
        $plateauY,
        $coordinates
    ) {
        $plateau = new Plateau(new PlateauSize($plateauX, $plateauY));

        $this->assertEquals(
            $coordinateIsInsideExpected,
            $plateau->coordinatesAreInsidePlateau(new Coordinate($coordinates[0], $coordinates[1]))
        );
    }

    public function test_whe_plateau_is_explored_explored_percentage_is_calculated_correctly()
    {
        $plateau = new Plateau(new PlateauSize(3, 3));
        $this->assertEquals(0, $plateau->getExploredPercentage());
        $plateau->marcCoordinateAsExplored(new Coordinate(0,0));
        $this->assertEquals(6.25, $plateau->getExploredPercentage());
        $plateau->marcCoordinateAsExplored(new Coordinate(1,0));
        $this->assertEquals(12.5, $plateau->getExploredPercentage());
        $plateau->marcCoordinateAsExplored(new Coordinate(2,0));
        $this->assertEquals(18.75, $plateau->getExploredPercentage());
        $plateau->marcCoordinateAsExplored(new Coordinate(3,0));
        $this->assertEquals(25, $plateau->getExploredPercentage());
    }

    public static function inputProvider()
    {
        return [
            [true, 5, 5, [4, 4]],
            [true, 5, 5, [0, 4]],
            [true, 5, 5, [0, 0]],
            [true, 5, 5, [5, 5]],
            [true, 5, 5, [0, 5]],
            [true, 5, 5, [5, 0]],
            [true, 0, 0, [0, 0]],
            [false, 5, 5, [5, 6]],
            [false, 5, 5, [6, 6]],
            [false, 6, 5, [5, 6]],
            [false, 100, 100, [100, 101]],
            [false, 5, 5, [0, 6]],
            [false, 5, 5, [6, 0]],
        ];
    }
}
