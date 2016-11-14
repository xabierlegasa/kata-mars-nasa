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

        if (!$this->isValidCoordinate($parts[0]) || !$this->isValidCoordinate($parts[1])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $coordinate
     * @return bool
     */
    private function isValidCoordinate($coordinate)
    {
        return (is_numeric($coordinate)
            && ctype_digit($coordinate)
            && $coordinate > 0
        );
    }
}
