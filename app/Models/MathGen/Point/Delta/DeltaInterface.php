<?php

namespace App\Models\MathGen\Point\Delta;

interface DeltaInterface
{
    /**
     * @return int|float
     */
    public function value();

    /**
     * @return string
     */
    public function __toString(): string;
}
