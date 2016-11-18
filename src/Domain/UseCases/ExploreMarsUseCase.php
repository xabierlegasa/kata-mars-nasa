<?php

namespace KataMarsNasa\Domain\UseCases;


use KataMarsNasa\Application\Validations\PlanOverlappingValidator;
use KataMarsNasa\Domain\Entities\Mission;
use KataMarsNasa\Domain\Services\InputToPlanTransformer;

class ExploreMarsUseCase
{
    /**
     * @var InputToPlanTransformer
     */
    private $inputToPlanTransformer;
    /**
     * @var PlanOverlappingValidator
     */
    private $planOverlappingValidator;

    /**
     * ExploreMarsUseCase constructor.
     * @param InputToPlanTransformer $inputToPlanTransformer
     * @param PlanOverlappingValidator $planOverlappingValidator
     */
    public function __construct(InputToPlanTransformer $inputToPlanTransformer, PlanOverlappingValidator $planOverlappingValidator)
    {
        $this->inputToPlanTransformer = $inputToPlanTransformer;
        $this->planOverlappingValidator = $planOverlappingValidator;
    }

    public function execute(array $input = [])
    {

        $plan = $this->inputToPlanTransformer->transform($input);

        $mission = new Mission($plan, $this->planOverlappingValidator);
        $mission->simulatePlan();

        return $mission;
    }
}
