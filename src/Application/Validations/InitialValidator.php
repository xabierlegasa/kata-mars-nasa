<?php

namespace KataMarsNasa\Application\Validations;


class InitialValidator
{
    public function validate(array $input)
    {
        $hasValidNumberOfLines = count($input) >= 1 && !(count($input) % 2 === 0);
        if (!$hasValidNumberOfLines) {
            throw new \InvalidArgumentException('The number of lines of the mission is invalid');
        }
    }
}
