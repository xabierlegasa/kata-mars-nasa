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

    /**
     * InputToPlanTransformer constructor.
     * @param InitialValidator $initialValidator
     * @param InputToPlateauSizeConverter $inputToPlateauSizeConverter
     * @param InputToRoversPositionConverter $inputToRoversPositionConverter
     */
    public function __construct(
        InitialValidator $initialValidator,
        InputToPlateauSizeConverter $inputToPlateauSizeConverter,
        InputToRoversPositionConverter $inputToRoversPositionConverter
    ) {
        $this->initialValidator = $initialValidator;
        $this->inputToPlateauSizeConverter = $inputToPlateauSizeConverter;
        $this->inputToRoversPositionConverter = $inputToRoversPositionConverter;
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









        $plan = new Plan();
        $plan->setPlateauSize($plateauSize);


        return $plan;
    }
}
