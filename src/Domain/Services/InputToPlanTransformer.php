<?php

namespace KataMarsNasa\Domain\Services;


use KataMarsNasa\Application\Validations\CoordinateValidator;
use KataMarsNasa\Application\Validations\InitialValidator;
use KataMarsNasa\Application\Validations\RoversMovementsValidator;
use KataMarsNasa\Application\Validations\RoversPositionValidator;
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
     * @var RoversMovementsValidator
     */
    private $roversMovementsValidator;
    /**
     * @var RoversPositionValidator
     */
    private $roversPositionValidator;

    /**
     * InputToPlanTransformer constructor.
     * @param InitialValidator $initialValidator
     * @param RoversMovementsValidator $roversMovementsValidator
     * @param RoversPositionValidator $roversPositionValidator
     */
    public function __construct(
        InitialValidator $initialValidator,
        RoversMovementsValidator $roversMovementsValidator,
        RoversPositionValidator $roversPositionValidator
    ) {
        $this->initialValidator = $initialValidator;
        $this->roversMovementsValidator = $roversMovementsValidator;
        $this->roversPositionValidator = $roversPositionValidator;
    }

    /**
     * @param array $input
     */
    public function transform(array $input)
    {
        if (!$this->initialValidator->validate($input)) {
            throw new \InvalidArgumentException('Your input is not valid. Check number of lines is correct');
        }

        $plateauSizeLine = trim(reset($input));


        $plateauSize = $this->


        $plan = new Plan();
        $plan->setPlateauSize();



        var_dump($input);


        var_dump($plateauSizeLine);
        var_dump($input);

        die;
    }
}
