<?php

namespace KataMarsNasa\Domain\Services;


use InvalidArgumentException;
use KataMarsNasa\Application\Validations\RoversMovementsValidator;
use KataMarsNasa\Domain\Entities\Movement;
use KataMarsNasa\Domain\Entities\RoverMovements;

class InputToRoverMovementsConverter
{
    /**
     * @var RoversMovementsValidator
     */
    private $roversMovementsValidator;

    /**
     * @param RoversMovementsValidator $roversMovementsValidator
     */
    public function __construct(RoversMovementsValidator $roversMovementsValidator)
    {
        $this->roversMovementsValidator = $roversMovementsValidator;
    }

    /**
     * @param string $line
     * @return RoverMovements
     */
    public function convert($line)
    {
        if (!$this->roversMovementsValidator->validate($line)) {
            throw new InvalidArgumentException('Rovers movement input is invalid');
        }

        $movements = [];
        $chars = str_split($line);
        foreach ($chars as $char) {
            $movements[] = new Movement($char);
        }

        return new RoverMovements($movements);
    }
}
