<?php

namespace App\Models\MathGen\Point\Coordinate;

use App\Models\MathGen\Point\Coordinate\Collection as CoordinateCollection;

interface GeneratorInterface
{
    /**
     * @return CoordinateCollection
     */
    public function execute(): CoordinateCollection;

    /**
     * @param int $pointKey
     * @return $this
     */
    public function setPointKey(int $pointKey): self;
}
