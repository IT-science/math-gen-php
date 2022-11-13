<?php
declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

use App\Models\Math\Interval\Interval;

class IntervalIntersection extends IntervalOperation
{
    /**
     * Function name in executor
     */
    const NAME = 'intersect';

    /**
     * @param Interval $intervalA
     * @param Interval $intervalB
     */
    public function __construct(Interval $intervalA, Interval $intervalB)
    {
        parent::__construct($intervalA);
        $this->operationRunner->addInterval($intervalB);
    }

    /**
     * @inheritDoc
     */
    public function operationName(): string
    {
        return 'intersection';
    }
}
