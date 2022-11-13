<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

class IsCrossed extends Operation
{
    /**
     * Overlap
     * https://en.wikipedia.org/wiki/Interval_tree (see: Overlap test)
     *
     * @return bool
     */
    public function execute(): bool
    {
        $intervalA = $this->intervals[0];
        $intervalB = $this->intervals[1];

        return $intervalA->left() < $intervalB->right()
            && $intervalA->right() > $intervalB->left();
    }
}
