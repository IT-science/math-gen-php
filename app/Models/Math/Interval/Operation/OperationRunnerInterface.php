<?php

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

interface OperationRunnerInterface
{
    /**
     * @param Interval $interval
     * @param int|null $key
     * @return $this
     */
    public function addInterval(Interval $interval, int $key = null): self;

    /**
     * @param string|null $name
     * @return mixed
     */
    public function execute(string $name = null);
}
