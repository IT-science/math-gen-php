<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point\Delta;

use App\Models\MathGen\Point\Point;

abstract class Delta implements DeltaInterface
{
    /**
     * @var Point
     */
    private $point;

    /**
     * @var float|int
     */
    private $value;

    /**
     * Delta constructor.
     */
    public function __construct(Point $point)
    {
        $this->point = $point;
        $this->value = $this->calculate();
    }

    /**
     * @return Point
     */
    public function point(): Point
    {
        return $this->point;
    }

    /**
     * @return float|int
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * @return mixed
     */
    abstract protected function calculate();
}
