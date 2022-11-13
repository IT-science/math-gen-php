<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use Illuminate\Support\Str;
use App\Models\Math\Interval\Exception\UnknownOperationException;
use App\Models\Math\Interval\Interval;

class OperationRunner implements OperationRunnerInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $intervals = [];

    /**
     * Operation constructor
     *
     * @param string|null $name
     */
    public function __construct(string $name = null)
    {
        $this->name = $name;
    }

    /**
     * @param Interval $interval
     * @param  int|null $key
     * @return $this
     */
    public function addInterval(Interval $interval, int $key = null): OperationRunnerInterface
    {
        if (null !== $key) {
            $this->intervals[$key] = $interval;
        } else {
            $this->intervals[] = $interval;
        }

        return $this;
    }

    /**
     * @param string|null $name
     * @return mixed
     * @throws UnknownOperationException
     */
    public function execute(string $name = null)
    {
        if (null !== $name) {
            $this->name = $name;
        }

        $className = 'App\Models\Math\Interval\Operation\\' . Str::studly($this->name);
        if (! class_exists($className)) {
            throw new UnknownOperationException("Unknown operation: $className");
        }

        $operation = new $className;
        foreach ($this->intervals as $interval) {
            $operation->addInterval($interval);
        }

        return $operation->execute();
    }

    /**
     * @return string
     */
    public function expr()
    {
        return ucfirst($this->name) . ': ' . join(', ', $this->intervals);
    }
}
