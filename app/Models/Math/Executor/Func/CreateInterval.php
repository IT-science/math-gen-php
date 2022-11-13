<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

use App\Models\Math\Interval\Interval;

class CreateInterval implements FunctionInterface
{
    /**
     * Function name in executor
     */
    const NAME = 'intr';

    /**
     * @var string
     */
    private $interval;

    /**
     * CreateInterval constructor.
     * @param string $interval
     */
    public function __construct(string $interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return Interval
     */
    public function execute(): Interval
    {
        return new Interval($this->interval);
    }
}
