<?php

namespace KataMarsNasa\Application\Validations;


class InputValidationResult
{
    /** @var bool */
    private $isValid;

    /** @var string */
    private $reason;

    /**
     * @param bool $isValid
     * @param string $reason
     */
    public function __construct($isValid, $reason)
    {
        $this->isValid = $isValid;
        $this->reason = $reason;
    }

    public function isValid()
    {
        return $this->isValid;
    }

    public function reason()
    {
        return $this->reason;
    }
}
