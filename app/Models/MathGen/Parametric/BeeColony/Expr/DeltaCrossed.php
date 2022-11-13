<?php
declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\Math\Interval\Interval;

class DeltaCrossed extends Expression
{
    /**
     * @var Interval
     */
    private $intervalCalculated;
    /**
     * @var Interval
     */
    private $intervalExperimental;

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
        return 'abs(wid(intr(v)) - wid(intersect(intr(v), intr(z))))';
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
        return abs(wid($v) - wid(intersect($v, $z)));
    }
}
