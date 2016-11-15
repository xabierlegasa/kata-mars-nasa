<?php

namespace KataMarsNasa\Application\Validations;


class InitialValidator
{
    public function validate(array $input)
    {
        return count($input) >= 1 && !(count($input) % 2 === 0);
    }
}
