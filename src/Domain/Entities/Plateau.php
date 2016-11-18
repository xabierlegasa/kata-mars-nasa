<?php

namespace KataMarsNasa\Domain\Entities;


class Plateau
{
    private $plateauSize;

    /**
     * A bi-dimensional array matching the plateau size where false is unexplored, and true is explored
     * @var array
     */
    private $exploredMap;

    public function __construct(PlateauSize $plateauSize)
    {
        $this->plateauSize = $plateauSize;
        $this->initExploredMap();
    }

    public function plateauSize()
    {
        return $this->plateauSize;
    }

    public function coordinatesAreInsidePlateau(Coordinate $coordinate)
    {

        $xIsInside = ($coordinate->x() >= 0) && ($coordinate->x() <= $this->plateauSize()->x());
        $yIsInside = ($coordinate->y() >= 0) && ($coordinate->y() <= $this->plateauSize()->y());

        return $xIsInside && $yIsInside;
    }

    public function marcCoordinateAsExplored(Coordinate $coordinate)
    {
        $this->exploredMap[$coordinate->x()][$coordinate->y()] = true;

    }

    private function initExploredMap()
    {
        for ($x = 0; $x <= $this->plateauSize()->x(); $x++) {
            for ($y = 0; $y <= $this->plateauSize()->y(); $y++) {
                $this->exploredMap[$x][$y] = false;
            }
        }
    }

    /**
     * Return the plateau explored percentage
     * @return float
     */
    public function getExploredPercentage()
    {
        $totalGrids = ($this->plateauSize()->x() + 1)  * ($this->plateauSize()->y() + 1);

        $explored = 0;
        for ($x = 0; $x <= $this->plateauSize()->x(); $x++) {
            for ($y = 0; $y <= $this->plateauSize()->y(); $y++) {
                if ($this->exploredMap[$x][$y]) {
                    $explored++;
                }
            }
        }

        return number_format(100 * $explored / $totalGrids, 2);
    }

}
