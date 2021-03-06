<?php

namespace KataMarsNasa\Application\Validations;


class CoordinateValidator
{
    /**
     * @param string $input
     * @return bool
     */
    public function validate($input)
    {
        if (!preg_match('/^[0-9]* [0-9]*$/', $input)) {
            return false;
        }

        $parts = explode(' ', $input);

        if ($parts[0] < 1 || $parts[1] < 1) {
            return false;
        }

        return true;
    }
}
