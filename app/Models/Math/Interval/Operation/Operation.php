<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

abstract class Operation implements OperationInterface
{
    /**
     * @var array
     */
    protected $intervals = [];

    /**
     * @param Interval $interval
     * @return OperationInterface
     */
    public function addInterval(Interval $interval): OperationInterface
    {
        $this->intervals[] = $interval;
        return $this;
    }
}
