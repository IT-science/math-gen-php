<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Operator;

use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Operation\OperationRunner;

abstract class Operator implements OperatorInterface
{
    /**
     * @var mixed
     */
    protected $a;

    /**
     * @var mixed
     */
    protected $b;

    /**
     * Operator constructor.
     * @param mixed $a
     * @param mixed $b
     */
    public function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    /**
     * @return Interval|int|float|string
     */
    public function execute()
    {
        if ($this->a instanceof Interval
            || $this->b instanceof Interval
        ) {
            $result = $this->executeInterval();
        } else {
            $result = $this->executeRegular();
        }

        return $result;
    }

    /**
     * @return OperationRunner
     */
    protected function intervalOperationRunner(): OperationRunner
    {
        $a = $this->a;
        $b = $this->b;

        return (new OperationRunner)
            ->addInterval(is_scalar($a) ? new Interval($a) : $a)
            ->addInterval(is_scalar($b) ? new Interval($b) : $b);
    }

    /**
     * @return Interval
     */
    abstract protected function executeInterval(): Interval;

    /**
     * @return int|float|string
     */
    abstract protected function executeRegular();
}
