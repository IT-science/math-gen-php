<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Operation\OperationRunner;

abstract class IntervalOperation implements FunctionInterface
{
    /**
     * @var OperationRunner
     */
    protected $operationRunner;

    /**
     * @param Interval $interval
     */
    public function __construct(Interval $interval)
    {
        $this->operationRunner = (new OperationRunner)
            ->addInterval($interval);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->operationRunner->execute($this->operationName());
    }

    /**
     * Operation name for runner
     *
     * @return string
     */
    abstract public function operationName(): string;
}
