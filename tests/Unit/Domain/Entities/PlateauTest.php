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
