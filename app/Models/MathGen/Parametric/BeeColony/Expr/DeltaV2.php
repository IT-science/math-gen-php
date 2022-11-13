<?php
declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\Math\Interval\Interval;

class DeltaV2 extends Expression
{
    /**
     * @var int|float
     */
    protected $v;

    /**
     * @var int|float
     */
    protected $z;

    /**
     * @var int|float
     */
    protected $a;

    /**
     * DeltaCrossed constructor.
     * @param int|float v
     * @param int|float z
     * @param int|float a
     */
    public function __construct($v, $z, $a)
    {
        parent::__construct();
        $this->v = $v;
        $this->z = $z;
        $this->a = $a;
    }

    /**
     * @inheritDoc
     */
    public function expr()
    {
        return '(v - (a * z + (1 - a) * z))^2';
        // return 'abs(mid(intr(v)) - mid(intr(z)))';
        // return 'max(allDeltas)';
    }

    /**
     * @return array
     */
    public function variables(): array
    {
        return [
            'v' => $this->v,
            'z' => $this->z,
            'a' => $this->a,
        ];
    }

    /*public function exprNative($v, $z)
    {
        return abs(mid($v) - mid($z));
    }*/
}
