<?php

namespace KataMarsNasa\Domain\Entities;


class Movement
{
    const RIGHT = 'R';
    const LEFT = 'L';
    const MOVE = 'M';

    /** @var string */
    private $movement;

    /**
     * Movement constructor.
     * @param $movement
     */
    public function __construct($movement)
    {
        $this->movement = $movement;
    }

    public function movement()
    {
        return $this->movement;
    }

    public function willMoveForward()
    {
        return $this->movement === self::MOVE;
    }

    public function willFlipRight()
    {
        return $this->movement === self::RIGHT;
    }

    public function willFlipLeft()
    {
        return $this->movement === self::LEFT;
    }
}
