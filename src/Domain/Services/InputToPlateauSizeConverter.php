<?php

namespace KataMarsNasa\Domain\Services;


use KataMarsNasa\Application\Validations\CoordinateValidator;
use KataMarsNasa\Domain\Entities\PlateauSize;

class InputToPlateauSizeConverter
{
    /**
     * @var CoordinateValidator
     */
    private $coordinateValidator;

    /**
     * InputToPlateauSizeConverter constructor.
     * @param CoordinateValidator $coordinateValidator
     */
    public function __construct(CoordinateValidator $coordinateValidator)
    {
        $this->coordinateValidator = $coordinateValidator;
    }

    /**
     * @param string $line
     * @return PlateauSize
     */
    public function convert($line)
    {
        if (!$this->coordinateValidator->validate($line)) {
            throw new \InvalidArgumentException('First line is invalid. Check plateau coordinates.');
        }

        $parts = explode(' ', $line);

        return new PlateauSize($parts[0], $parts[1]);
    }
}
