<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\MathGen\Parametric\BeeColony\Config\Coordinates;

class PointSeekerInitial extends Expression
{
    /**
     * @inheritDoc
     */
    protected $checkNativeResult = false;

    /**
     * @var int|float
     */
    private $min;

    /**
     * @var int|float
     */
    private $max;

    /**
     * @return string
     */
    public function expr(): string
    {
        return $this->config->get('parametric.bee_colony.point_seeker_initial');
    }

    public function exprNative($min, $max)
    {
        $result = $max + randf(0, 1) * ($min - $max);

        return (string) $result;
    }

    /**
     * @return array
     */
    public function variables(): array
    {
        return [
            'min' => $this->min(),
            'max' => $this->max(),
        ];
    }

    /**
     * @return float|int
     */
    public function min()
    {
        return $this->min;
    }

    /**
     * @param float|int $min
     * @return PointSeekerInitial
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @return float|int
     */
    public function max()
    {
        return $this->max;
    }

    /**
     * @param float|int $max
     * @return PointSeekerInitial
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }
}
