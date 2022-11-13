<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

class Random implements FunctionInterface
{
    /**
     * Function name in executor
     */
    const NAME = 'rand';

    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * Random constructor.
     * @param $min
     * @param $max
     */
    public function __construct($min, $max)
    {
        $this->min = (int) $min;
        $this->max = (int) $max;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function execute(): int
    {
        $result = random_int($this->min, $this->max);
        return $result;
    }
}
