<?php

namespace KataMarsNasa\Domain\Entities;


class Plan
{
    /** @var PlateauSize  */
    private $plateauSize;

    /**
     * Plan constructor.
     * @param PlateauSize $plateauSize
     */
    public function __construct(PlateauSize $plateauSize)
    {
        $this->plateauSize = $plateauSize;
    }
}
