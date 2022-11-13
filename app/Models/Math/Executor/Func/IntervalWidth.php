<?php
declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

class IntervalWidth extends IntervalOperation
{
    /**
     * Function name in executor
     */
    const NAME = 'wid';

    /**
     * @inheritDoc
     */
    public function operationName(): string
    {
        return 'width';
    }
}
