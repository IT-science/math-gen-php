<?php
declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

class IntervalMiddle extends IntervalOperation
{
    /**
     * Function name in executor
     */
    const NAME = 'mid';

    /**
     * @inheritDoc
     */
    public function operationName(): string
    {
        return 'middle';
    }
}
