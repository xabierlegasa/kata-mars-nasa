<?php

namespace KataMarsNasa\Domain\UseCases;


use KataMarsNasa\Domain\Services\InputToPlanTransformer;

class ExploreMarsUseCase
{
    /**
     * @var InputToPlanTransformer
     */
    private $inputToPlanTransformer;

    /**
     * ExploreMarsUseCase constructor.
     * @param InputToPlanTransformer $inputToPlanTransformer
     */
    public function __construct(InputToPlanTransformer $inputToPlanTransformer)
    {
        $this->inputToPlanTransformer = $inputToPlanTransformer;
    }

    public function execute(array $input)
    {

        $plan = $this->inputToPlanTransformer->transform($input);

        var_dump($plan);
        die;
        return true;
    }
}
