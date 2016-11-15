<?php

namespace KataMarsNasa\Application\Validations;


use KataMarsNasa\Domain\Entities\PlateauSize;

class RoversPositionValidator
{
    /**
     * @param string $input
     * @param PlateauSize $plateauSize
     * @return bool
     */
    public function validate($input, PlateauSize $plateauSize)
    {
        if (!preg_match('/^[0-9]* [0-9]* [NSEW]$/', $input)) {
            return false;
        }

        $parts = explode(' ', $input);

        if ($parts[0] < 1 || $parts[0] > $plateauSize->x()) {
            return false;
        }

        if ($parts[1] < 1 || $parts[1] > $plateauSize->y()) {
            return false;
        }

        return true;
    }
}
