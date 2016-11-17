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
        return true;
    }
}
