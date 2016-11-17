<?php

namespace KataMarsNasa\Domain\Entities;


class Plateau
{
    private $plateauSize;

    public function __construct(PlateauSize $plateauSize)
    {
        $this->plateauSize = $plateauSize;
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
}
