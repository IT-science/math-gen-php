<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

class Middle extends Operation
{
    /**
     * Find middle of interval
     *
     * @return float|int
     */
    public function execute()
    {
        $interval = $this->intervals[0];

        return ($interval->left() + $interval->right()) / 2;
    }
}
