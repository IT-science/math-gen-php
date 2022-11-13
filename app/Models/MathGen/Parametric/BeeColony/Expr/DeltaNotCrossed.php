<?php
declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\Math\Interval\Interval;

class DeltaNotCrossed extends Expression
{
    /**
     * @var Interval
     */
    protected $intervalCalculated;
    /**
     * @var Interval
     */
    protected $intervalExperimental;

    /**
     * DeltaCrossed constructor.
     * @param Interval $intervalCalculated
     * @param Interval $intervalExperimental
     */
    public function __construct(Interval $intervalCalculated, Interval $intervalExperimental)
    {
        parent::__construct();
        $this->intervalCalculated = $intervalCalculated;
        $this->intervalExperimental = $intervalExperimental;
    }

    /**
     * @inheritDoc
     */
    public function expr()
    {
        return 'abs(mid(intr(v)) - mid(intr(z)))';
        // return 'max(allDeltas)';
    }

    /**
     * @return array
     */
    public function variables(): array
    {
        return [
            'v' => $this->intervalCalculated,
            'z' => $this->intervalExperimental,
        ];
    }

    public function exprNative($v, $z)
    {
        return abs(mid($v) - mid($z));
    }
}
