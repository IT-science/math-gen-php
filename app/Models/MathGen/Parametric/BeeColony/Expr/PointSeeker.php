<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\MathGen\Point\Collection;
use App\Models\MathGen\Point\Point;

class PointSeeker extends Expression
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
     * @var int
     */
    private $pointKey;

    /**
     * @var int
     */
    private $coordinateKey;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * PointSeeker constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        parent::__construct();
        $this->collection = $collection;
    }

    /**
     * @return array|string
     */
    public function expr()
    {
        return $this->config->get('parametric.bee_colony.point_seeker');
    }

    public function exprNative(...$vars)
    {
        extract($vars);

        $distance = randf(-1, 1);
        $direction1 = $currentCoord + $distance * ($currentCoord - $otherCoord);
        $direction2 = $currentCoord + ($distance * -1) * ($currentCoord - $otherCoord);
        $result = $direction1 > $max || $direction1 < $min ? $direction2 : $direction1;

        return (string) $result;
    }

    /**
     * @return array
     */
    public function variables(): array
    {
        return [
            'currentCoord' => $this->coordinateValue($this->currentPoint($this->pointKey())),
            'otherCoord' => $this->coordinateValue($this->otherPoint($this->pointKey())),
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
     * @return $this
     */
    public function setMin($min): self
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
     * @return $this
     */
    public function setMax($max): self
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @return int
     */
    public function pointKey(): int
    {
        return $this->pointKey;
    }

    /**
     * @param int $pointKey
     * @return PointSeeker
     */
    public function setPointKey(int $pointKey): PointSeeker
    {
        $this->pointKey = $pointKey;
        return $this;
    }

    /**
     * @return int
     */
    public function coordinateKey(): int
    {
        return $this->coordinateKey;
    }

    /**
     * @param int $coordinateKey
     * @return PointSeeker
     */
    public function setCoordinateKey(int $coordinateKey): PointSeeker
    {
        $this->coordinateKey = $coordinateKey;
        return $this;
    }

    /**
     * @param int $currentPointKey
     * @return Point
     */
    public function currentPoint(int $currentPointKey): Point
    {
        return $this->collection->get($currentPointKey);
    }

    /**
     * @param int $currentPointKey
     * @return Point
     */
    public function otherPoint(int $currentPointKey): Point
    {
        $collection = clone $this->collection;
        $collection->remove($currentPointKey);
        $point = $collection->random();

        return $point;
    }

    /**
     * @param Point $point
     * @return float|int
     */
    private function coordinateValue(Point $point)
    {
        return $point
            ->coordinates()
            ->get($this->coordinateKey())
            ->value();
    }
}
