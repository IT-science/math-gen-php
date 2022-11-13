<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

class Intersection extends Operation
{
    /**
     * Previous method name: cross
     *
     * Intersection
     * https://scicomp.stackexchange.com/questions/26258/the-easiest-way-to-find-intersection-of-two-intervals
     * https://github.com/petrhejna/php-math-interval
     *
     * @return Interval
     * @throws \Exception
     */
    public function execute(): Interval
    {
        $intervalA = $this->intervals[0];
        $intervalB = $this->intervals[1];

        $isCrossed = (new IsCrossed)
            ->addInterval($intervalA)
            ->addInterval($intervalB)
            ->execute();

        if (! $isCrossed) {
            throw new \Exception;
        }

        return new Interval(
            max($intervalA->left(), $intervalB->left()),
            min($intervalA->right(), $intervalB->right())
        );
    }
}
