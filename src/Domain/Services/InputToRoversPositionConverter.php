<?php

namespace KataMarsNasa\Domain\Services;

use KataMarsNasa\Application\Validations\RoversPositionValidator;
use KataMarsNasa\Domain\Entities\PlateauSize;
use KataMarsNasa\Domain\Entities\Position;

class InputToRoversPositionConverter
{
    /**
     * @var RoversPositionValidator
     */
    private $roversPositionValidator;

    /**
     * InputToPlateauSizeConverter constructor.
     * @param RoversPositionValidator $roversPositionValidator
     */
    public function __construct(RoversPositionValidator $roversPositionValidator)
    {
        $this->roversPositionValidator = $roversPositionValidator;
    }

    /**
     * @param string $line
     * @param PlateauSize $plateauSize
     * @return PlateauSize
     */
    public function convert($line, PlateauSize $plateauSize)
    {
        if (!$this->roversPositionValidator->validate($line, $plateauSize)) {
            throw new \InvalidArgumentException('Rovers position input is invalid');
        }

        $parts = explode(' ', $line);

        return new Position($parts[0], $parts[1], $parts[2]);
    }
}
