<?php

namespace KataMarsNasa\Application\Validations;


class InputValidator
{
    public function validate($input)
    {
        if (empty($input)) {
            throw new \InvalidArgumentException('Input cant not be empty');
        }




    }
}
