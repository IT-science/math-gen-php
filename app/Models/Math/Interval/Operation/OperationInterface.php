<?php

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

interface OperationInterface
{
    /**
     * @param Interval $interval
     * @return $this
     */
    public function addInterval(Interval $interval): self;

    /**
     * @return mixed
     */
    public function execute();
}
