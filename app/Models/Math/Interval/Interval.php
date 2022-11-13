<?php

declare(strict_types=1);

namespace App\Models\Math\Interval;

use Interval\Interval as IntervalBase;

class Interval implements IntervalInterface
{
    /**
     * @var IntervalBase
     */
    private $interval;

    /**
     * Interval constructor.
     * @param $left
     * @param int|float|null $right
     */
    public function __construct($left, $right = null)
    {
        $leftOrig = $left;
        $rightOrig = $right;

        if (-INF === $left || (is_numeric($left) && $left < -999999999)) {
            $left = -999999999;
        }

        if (INF === $left || (is_numeric($left) && $left > 999999999)) {
            $left = 999999999;
        }

        if (-INF === $right || (null !== $right && $right < -999999999)) {
            $right = -999999999;
        }

        if (INF === $right || (null !== $right && $right > 999999999)) {
            $right = 999999999;
        }

        if (null !== $right && $left > $right) {
            dd($leftOrig, $rightOrig, $left, $right, 'Wrong interval');
        }

        $leftOrig = $left;
        $rightOrig = $right;

        if (! is_numeric($left)) {
            $this->interval = IntervalBase::create($left);
        } elseif (null === $right) {
            $left = $this->prepareBoundValue($left);
            $this->interval = new IntervalBase($left, $left);
        } else {
            $left = $this->prepareBoundValue($left);
            $right = $this->prepareBoundValue($right);
            $this->interval = new IntervalBase($left, $right);
        }

        if ('INF' === $this->left() || '-INF' === $this->left()) {
            dd($leftOrig, $rightOrig, $this->left(), $this->right());
        }

        if ('INF' === $this->right() || '-INF' === $this->right()) {
            dd($leftOrig, $rightOrig, $this->left(), $this->right());
        }
    }

    /**
     * @return IntervalBase
     */
    public function unwrap()
    {
        return $this->interval;
    }

    /**
     * @return float|int|string
     */
    public function left()
    {
        $value = (string) $this->unwrap()->getStart()->getValue();
        $value = $this->prepareBoundValue($value);

        return $value;
    }

    /**
     * @return float|int|string
     */
    public function right()
    {
        $value = (string) $this->unwrap()->getEnd()->getValue();
        $value = $this->prepareBoundValue($value);

        return $value;
    }

    /**
     * @return float[]|int[]|string[]
     */
    public function asArray(): array
    {
        return [$this->left(), $this->right()];
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return (string) $this->unwrap();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->asString();
    }

    /**
     * @param $value
     * @return float|int|string
     */
    protected function prepareBoundValue($value)
    {
        if (is_numeric($value)) {
            $value = (float) $value;
        }

        if ($value == (int) $value) {
            $value = (int) $value;
        }

        return $value;
    }
}
