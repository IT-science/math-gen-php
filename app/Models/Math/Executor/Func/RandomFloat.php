<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

class RandomFloat implements FunctionInterface
{
    /**
     * Function name in executor
     */
    const NAME = 'randf';

    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * @var int
     */
    protected $precision = 4;

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
     * @return float
     * @throws \Exception
     */
    public function execute(): float
    {
        $result = random_int($this->min, $this->max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX);
        if (null !== $this->precision) {
            $result = round($result, $this->precision);
        }

        return $result;
    }
}
