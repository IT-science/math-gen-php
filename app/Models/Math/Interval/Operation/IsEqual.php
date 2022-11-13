<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

class IsEqual extends Operation
{
    /**
     * @return bool
     */
    public function execute(): bool
    {
        $intervalA = $this->intervals[0];
        $intervalB = $this->intervals[1];

        /*return $intervalA->unwrap()->equals($intervalB->unwrap());*/

        return $intervalA->left() === $intervalB->left()
            && $intervalA->right() === $intervalB->right();
    }
}
