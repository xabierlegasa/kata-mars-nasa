<?php

namespace KataMarsNasa\Application\Validations;


class InputValidator
{
    /**
     * @param $input
     * @return bool
     */
    public function validate($input)
    {
        if (empty($input)) {
            return $this->invalidBecause('Input can not be empty');
        }

        if (!$this->isValidCoordinates($input)) {
            return $this->invalidBecause('Invalid upper-right coordinates');
        }

        return new InputValidationResult(true, '');
    }

    private function invalidBecause($reason)
    {
        return new InputValidationResult(false, $reason);
    }

    private function isValidCoordinates($line)
    {
        $parts = explode(' ', $line);

        if (count($parts) <> 2) {
            return false;
        }

        $x = $parts[0];
        $y = $parts[1];

        if ($this->isNotValid)



        return true;
    }
}
