<?php

namespace KataMarsNasa\Application\Validations;


class InputValidator
{
    const ORIENTATION_NORTH = 'N';
    const ORIENTATION_SOUTH = 'S';
    const ORIENTATION_EAST = 'E';
    const ORIENTATION_WEST = 'W';

    /**
     * Takes a non associative array of order-lines and return true if it is a valid plan, or false otherwise
     * @param array $lines An array of lines
     * @return bool
     */
    public function validate(array $lines)
    {
        if (!$this->hasValidNumberOfLines($lines)) {
            return $this->invalidBecause('Number of lines is incorrect');
        }

        if (!$this->hasValidCoordinates($lines[0])) {
            return $this->invalidBecause('Invalid upper-right coordinates');
        }


        list ($numGridsInX, $numGridsInY) = $this->getNumGrids($lines[0]);
        $numLines = count($lines);
        for ($x = 1; $x <= $numLines - 1; $x++) {
            if ($x % 2 != 0) {
                if (!$this->isValidRoversPosition($lines[$x], $numGridsInX, $numGridsInY)) {
                    return $this->invalidBecause('Rovers position at line ' . ($x+1) .' is invalid');
                }
            } else {
                if (!$this->isValidRoversMovements($lines[$x])) {
                    return $this->invalidBecause('Rovers movements at line ' . ($x + 1) . ' are invalid');
                }
            }
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
    private function hasValidCoordinates($line)
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

    /**
     * A plan must have 1, 3, 5, 7, 9... number of lines
     * @param array $lines
     * @return bool
     */
    private function hasValidNumberOfLines(array $lines)
    {
        return count($lines) >= 1 && !(count($lines) % 2 === 0);
    }

    private function isValidRoversPosition($line, $numGridsInX, $numGridsInY)
    {
        $parts = explode(' ', $line);

        if (count($parts) <> 3) {
            return false;
        }

        $xPosIsValid = $this->isValidRoversPos($parts[0], $numGridsInX);
        $yPosIsValid = $this->isValidRoversPos($parts[1], $numGridsInY);

        if (!$xPosIsValid || !$yPosIsValid) {
            return false;
        }

        if (!in_array($parts[2],
            [
                self::ORIENTATION_NORTH,
                self::ORIENTATION_SOUTH,
                self::ORIENTATION_EAST,
                self::ORIENTATION_WEST
            ])
        ) {
            return false;
        }

        return true;
    }

    private function isValidRoversPos($pos, $numGridsInAxis)
    {
        return (is_numeric($pos)
            && ctype_digit($pos)
            && (int) $pos <= $numGridsInAxis
        );
    }

    private function getNumGrids($line)
    {
        $parts = explode(' ', $line);

        return [
            (int) $parts[0],
            (int) $parts[1]
        ];
    }

    private function isValidRoversMovements($string)
    {

    }
}
