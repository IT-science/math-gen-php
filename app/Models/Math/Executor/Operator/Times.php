<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Operator;

use App\Models\Math\Interval\Interval;

class Times extends Operator
{
    /**
     * Operator token
     */
    const OPERATOR = '*';

    /**
     * Priority
     */
    const PRIORITY = 180;

    /**
     * Operator type
     */
    const IS_RIGHT_ASSOC = false;

    /**
     * @return Interval
     * @throws \App\Models\Math\Interval\Exception\UnknownOperationException
     */
    protected function executeInterval(): Interval
    {
        return $this->intervalOperationRunner()
            ->execute('multiplication');
    }

    /**
     * @return float|int|string
     */
    protected function executeRegular()
    {
        return $this->a * $this->b;
    }
}
