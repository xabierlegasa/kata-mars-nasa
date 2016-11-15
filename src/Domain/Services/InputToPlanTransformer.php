<?php

namespace KataMarsNasa\Domain\Services;


use KataMarsNasa\Application\Validations\InitialValidator;
use KataMarsNasa\Domain\Entities\Plan;
use KataMarsNasa\Domain\Entities\Rover;

class InputToPlanTransformer
{
    /**
     * @var InitialValidator
     */
    private $initialValidator;
    /**
     * @var InputToPlateauSizeConverter
     */
    private $inputToPlateauSizeConverter;

    /** @var InputToRoverMovementsConverter  */
    private $inputToRoverMovementsConverter;

    /**
     * InputToPlanTransformer constructor.
     * @param InitialValidator $initialValidator
     * @param InputToPlateauSizeConverter $inputToPlateauSizeConverter
     * @param InputToRoversPositionConverter $inputToRoversPositionConverter
     * @param InputToRoverMovementsConverter $inputToRoverMovementsConverter
     */
    public function __construct(
        InitialValidator $initialValidator,
        InputToPlateauSizeConverter $inputToPlateauSizeConverter,
        InputToRoversPositionConverter $inputToRoversPositionConverter,
        InputToRoverMovementsConverter $inputToRoverMovementsConverter
    ) {
        $this->initialValidator = $initialValidator;
        $this->inputToPlateauSizeConverter = $inputToPlateauSizeConverter;
        $this->inputToRoversPositionConverter = $inputToRoversPositionConverter;
        $this->inputToRoverMovementsConverter = $inputToRoverMovementsConverter;
    }

    /**
     * @param array $input
     * @return Plan
     */
    public function transform(array $input)
    {
        if (!$this->initialValidator->validate($input)) {
            throw new \InvalidArgumentException('Your input is not valid. Check number of lines is correct');
        }

        $plateauSizeLine = trim(array_shift($input));
        $plateauSize = $this->inputToPlateauSizeConverter->convert($plateauSizeLine);


        $plan = new Plan($plateauSize);

        for ($x = 0; $x < count($input); $x = $x + 2) {
            /** Rovers starting position */
            $linePosition = $input[$x];
            $position = $this->inputToRoversPositionConverter->convert(trim($linePosition), $plateauSize);
            $lineMovements = $input[$x+1];
            $movements = $this->inputToRoverMovementsConverter->convert(trim($lineMovements));

            $rover = new Rover($position, $movements);
            $plan->addRover($rover);
        }

        return $plan;
    }
}
