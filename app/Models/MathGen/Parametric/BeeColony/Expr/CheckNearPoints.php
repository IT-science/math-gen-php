<?php
declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\MathGen\Point\Collection;
use App\Models\MathGen\Point\Point;

class CheckNearPoints extends Expression
{
    /**
     * @var Point
     */
    private $currentPoint;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @param Point $currentPoint
     * @param Collection $collection
     */
    public function __construct(Point $currentPoint, Collection $collection)
    {
        parent::__construct();
        $this->currentPoint = $currentPoint;
        $this->collection = $collection;
    }

    /**
     * @inheritDoc
     */
    public function expr()
    {
        return [
            'P = (1 - delta) / deltas',
            'round(P * countBees)',
        ];
    }

    /**
     * @inheritDoc
     */
    public function variables(): array
    {
        return [
            'delta' => (new NormalizeDelta($this->currentPoint, $this->collection))->execute(),
            'deltas' => $this->deltaSum(),
            'countBees' => $this->config->get('parametric.bee_colony.count_bees'),
        ];
    }

    /**
     * @return int|float
     */
    private function deltaSum()
    {
        $total = 0;
        foreach ($this->collection->all() as $point) {
            $total += 1 - (new NormalizeDelta($point, $this->collection))->execute();
        }

        return $total;
    }

    /**
     * Need to normalize delta for this expression
     *
     * @param $D_g_l
     * @param $D_g_l_all
     * @return float|int
     */
    private function formula14($D_g_l, $D_g_l_all)
    {
        // dump($D_g_l);
        $D_g_l = $this->formula_normalize($D_g_l, $D_g_l_all);
        // dd($D_g_l);
        foreach ($D_g_l_all as &$_D_g_l) {
            $_D_g_l = $this->formula_normalize($_D_g_l, $D_g_l_all);
            $this->countIterations++;
        }

        foreach ($D_g_l_all as &$val) {
            $val = 1 - $val;
            $this->countIterations++;
        }

        $P_l = (1 - $D_g_l) / array_sum($D_g_l_all);

        return $P_l;
    }

    /**
     * Normalization of delta g_l for finding P_l
     *
     * @param $D
     * @param $allD
     * @return float|int
     */
    private function formula_normalize($D, $allD)
    {
        $D_normalized = ($D - min($allD)) / (max($allD) - min($allD));

        return $D_normalized;
    }

    /**
     * @param float|int $P Result of $formula14
     * @return float|int
     */
    private function formula15($P_l)
    {
        $m_l = round($P_l * self::S);

        return $m_l;
    }
}
