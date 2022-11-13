<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Operator;

use App\Models\Math\Interval\Interval;
use NXP\Exception\DivisionByZeroException;

class Obelus extends Operator
{
    /**
     * Operator token
     */
    const OPERATOR = '/';

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
            ->execute('division');
    }

    /**
     * @return float|int|string
     */
    protected function executeRegular()
    {
        if ($this->b == 0) {
            return 0;
            //throw new DivisionByZeroException();
        }

        return $this->a / $this->b;
    }
}
