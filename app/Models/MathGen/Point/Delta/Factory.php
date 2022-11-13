<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point\Delta;

use App\Models\MathGen\Point\Point;
use App\Models\MathGen\Point\Stub\DeltaStub;

class Factory
{
    /**
     * @var string
     */
    private $class;

    /**
     * Factory constructor.
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @param Point $point
     * @return DeltaInterface
     */
    public function one(Point $point): DeltaInterface
    {
        return new $this->class($point);
    }
}
