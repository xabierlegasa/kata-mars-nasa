<?php

namespace KataMarsNasa\Domain\Services;


use KataMarsNasa\Application\Validations\CoordinateValidator;
use KataMarsNasa\Application\Validations\InitialValidator;
use KataMarsNasa\Application\Validations\RoversMovementsValidator;
use KataMarsNasa\Application\Validations\RoversPositionValidator;

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
     * @param CoordinateValidator $coordinateValidator
     * @param RoversMovementsValidator $roversMovementsValidator
     * @param RoversPositionValidator $roversPositionValidator
     */
    public function __construct(
        InitialValidator $initialValidator,
        CoordinateValidator $coordinateValidator,
        RoversMovementsValidator $roversMovementsValidator,
        RoversPositionValidator $roversPositionValidator
    ) {
        $this->coordinateValidator = $coordinateValidator;
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

        var_dump($input);

        $plateauSizeLine = reset($input);

        var_dump($plateauSizeLine);
        var_dump($input);

        die;
    }
}
