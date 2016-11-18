<?php

namespace KataMarsNasa\Domain\Services;


use KataMarsNasa\Application\Validations\InitialValidator;
use KataMarsNasa\Application\Validations\PlanOverlappingValidator;
use KataMarsNasa\Domain\Entities\Plan;
use KataMarsNasa\Domain\Entities\Plateau;
use KataMarsNasa\Domain\Entities\Rover;

class InputToPlanTransformer
{
    /**
     * @var InitialValidator
     */
    private $initialValidator;

    /**
     * @var PlanOverlappingValidator
     */
    private $planOverlappingValidator;

    /**
     * @var InputToPlateauSizeConverter
     */
    private $inputToPlateauSizeConverter;

    /** @var InputToRoverMovementsConverter  */
    private $inputToRoverMovementsConverter;

    /**
     * InputToPlanTransformer constructor.
     * @param InitialValidator $initialValidator
     * @param PlanOverlappingValidator $planOverlappingValidator
     * @param InputToPlateauSizeConverter $inputToPlateauSizeConverter
     * @param InputToRoversPositionConverter $inputToRoversPositionConverter
     * @param InputToRoverMovementsConverter $inputToRoverMovementsConverter
     */
    public function __construct(
        InitialValidator $initialValidator,
        PlanOverlappingValidator $planOverlappingValidator,
        InputToPlateauSizeConverter $inputToPlateauSizeConverter,
        InputToRoversPositionConverter $inputToRoversPositionConverter,
        InputToRoverMovementsConverter $inputToRoverMovementsConverter
    ) {
        $this->initialValidator = $initialValidator;
        $this->planOverlappingValidator = $planOverlappingValidator;
        $this->inputToPlateauSizeConverter = $inputToPlateauSizeConverter;
        $this->inputToRoversPositionConverter = $inputToRoversPositionConverter;
        $this->inputToRoverMovementsConverter = $inputToRoverMovementsConverter;
    }

    /**
     * @param array $input
     * @return Plan
     * @throws \InvalidArgumentException
     */
    public function transform(array $input)
    {
        $this->initialValidator->validate($input);

        $plateauSizeLine = trim(array_shift($input));
        $plateauSize = $this->inputToPlateauSizeConverter->convert($plateauSizeLine);


        $plan = new Plan(new Plateau($plateauSize));

        for ($x = 0; $x < count($input); $x = $x + 2) {
            /** Rovers starting position */
            $linePosition = $input[$x];
            $position = $this->inputToRoversPositionConverter->convert(trim($linePosition), $plateauSize);
            $lineMovements = $input[$x+1];
            $movements = $this->inputToRoverMovementsConverter->convert(trim($lineMovements));

            $rover = new Rover($position, $movements);
            $plan->addRover($rover);
        }

        $this->planOverlappingValidator->validate($plan);

        return $plan;
    }
}
