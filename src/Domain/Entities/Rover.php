<?php

namespace KataMarsNasa\Domain\Entities;


class Rover
{
    /**
     * @var Position
     */
    private $roversPosition;

    /**
     * Rover constructor.
     * @param Position $roversPosition
     */
    public function __construct(Position $roversPosition)
    {
        $this->roversPosition = $roversPosition;
    }
}
