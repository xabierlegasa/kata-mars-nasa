<?php

namespace KataMarsNasa\Application\Validations;


class RoversMovementsValidator
{
    /**
     * @param string $input
     * @return bool
     */
    public function validate($input)
    {
        return preg_match('/^[LRM]+$/', $input);
    }
}
