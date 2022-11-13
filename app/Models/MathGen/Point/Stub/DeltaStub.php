<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point\Stub;

use App\Models\MathGen\Point\Delta\Delta;

class DeltaStub extends Delta
{
    /**
     * @inheritDoc
     */
    protected function calculate()
    {
        return random_int(1, 10);
    }
}
