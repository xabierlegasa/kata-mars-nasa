<?php

namespace KataMarsNasa\Domain\Entities;


class RoverMovements
{
    /** @var array Array of Movement objects */
    private $movements;

    /**
     * @param array $movements
     */
    public function __construct(array $movements = [])
    {
        $this->movements = $movements;
    }

    public function movements()
    {
        return $this->movements;
    }

    /**
     * @param int $movementNumber
     * @return Movement
     */
    public function getMovement($movementNumber)
    {
        return $this->movements[$movementNumber];
    }
}
