<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;

class Addition extends Operation
{
    /**
     * @return Interval
     */
    public function execute(): Interval
    {
        $intervalA = $this->intervals[0];
        $intervalB = $this->intervals[1];

        $numbers = [
            $intervalA->left() + $intervalB->left(),
            //$intervalA->left() + $intervalB->right(),
            //$intervalA->right() + $intervalB->left(),
            $intervalA->right() + $intervalB->right(),
        ];

        return new Interval(min($numbers), max($numbers));
    }
}
