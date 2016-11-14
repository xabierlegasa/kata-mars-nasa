<?php

namespace KataMarsNasa\Application\Validations;


class InputValidator
{
    /**
     * Takes a non associative array of order-lines and return true if it is a valid plan, or false otherwise
     * @param array $input An array of lines
     * @return bool
     */
    public function validate(array $input)
    {
        if (empty($input)) {
            return $this->invalidBecause('Input can not be empty');
        }

        if (!$this->isValidCoordinates($input[0])) {
            return $this->invalidBecause('Invalid upper-right coordinates');
        }

        return new InputValidationResult(true, '');
    }

    private function invalidBecause($reason)
    {
        return new InputValidationResult(false, $reason);
    }

    /**
     * @param string $line
     * @return bool
     */
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
