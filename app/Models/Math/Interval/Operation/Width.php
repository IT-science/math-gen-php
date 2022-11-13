<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

class Width extends Operation
{
    /**
     * Find width of interval
     *
     * @return float|int
     */
    public function execute()
    {
        $interval = $this->intervals[0];

        return abs($interval->left() - $interval->right());
    }
}
