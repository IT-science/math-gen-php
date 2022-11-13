<?php

namespace App\Models\MathGen\Point;

interface StateInterface
{
    /**
     * @return int
     */
    public function pointKey(): int;

    /**
     * @param int $pointKey
     * @return $this
     */
    public function setPointKey(int $pointKey): self;

    /**
     * @return int
     */
    public function coordinateKey(): int;

    /**
     * @param int $coordinateKey
     * @return $this
     */
    public function setCoordinateKey(int $coordinateKey): self;
}
