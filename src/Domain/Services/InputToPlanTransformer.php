<?php

namespace KataMarsNasa\Domain\Services;


use KataMarsNasa\Application\Validations\CoordinateValidator;
use KataMarsNasa\Application\Validations\InitialValidator;
use KataMarsNasa\Domain\Entities\Plan;

class InputToPlanTransformer
{
    /**
     * @var CoordinateValidator
     */
    private $coordinateValidator;

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

        $plateauSizeLine = trim(reset($input));
        $plateauSize = $this->inputToPlateauSizeConverter->convert($plateauSizeLine);

        for ($x = 0; $x < count($input); $x = $x + 2) {
            /** Rovers starting coordinates */
            $lineCoordinates = $input[$x];

            $lineMovements = $input[$x+1];

        }


//        foreach($input as $line) {
//
//            if () { // for rover position
//                $this->inputToRoverMovementsConverter->convert()
//
//            } else { // add rover
//
//            }
//        }










        $plan = new Plan();
        $plan->setPlateauSize($plateauSize);


        return $plan;
    }
}
