<?php

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

class Alpha
{
    static $n = 0;

    public $min = 0;
    public $max = 1;
    public $step = 0.001;

    public $expr;

    public $minAlpha;
    public $minResult;

    public function __construct(\Closure $expr)
    {
        $this->expr = $expr;
    }

    public function find()
    {
        for ($a = $this->min; $a <= $this->max; $a += $this->step) {
            self::$n++;

            $result = ($this->expr)($a);

            if ($result < $this->minResult || null === $this->minResult) {
                $this->minAlpha = $a;
                $this->minResult = $result;
            }

            if ($result <= 0.000001) {
                break;
            }
        }

        return $this->minAlpha;
    }
}
