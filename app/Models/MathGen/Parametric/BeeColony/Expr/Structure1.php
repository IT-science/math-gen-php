<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\Math\Interval\Interval;
use App\Models\MathGen\Point\Point;

class Structure1 extends Expression
{
    public static array $calculatedData = [];
    public static int $i = 0;

    /**
     * @var Point
     */
    private $point;

    public function __construct(Point $point)
    {
        parent::__construct();

        $this->point = $point;
    }

    /**
     * @return array
     */
    public function execute()
    {
        $experimentalData = $this->config->get('parametric.bee_colony.experimental_data');
        $I = count($experimentalData['left']) - 1;
        $exprInitial = $this->config->get('parametric.bee_colony.expr_initial');

        $iStart = 4;

        $matrix = [];

        foreach (range(0, $I) as $i) {
            self::$i = $i;

            if ($i >= $iStart) {
                $matrix[$i] = parent::execute();
            }
            /**
             * Calculate mid(experimentalInterval) * 0.0005 if structure is out of matrix
             */
            else {
                if (isset($exprInitial[$i])) {
                    $matrix[$i] = new Interval(...$exprInitial[$i]);
                } else {
                    $left = $experimentalData['left'][$i];
                    $right = $experimentalData['right'][$i];
                    $intervalExperimental = new Interval($left, $right);
                    $mid = mid($intervalExperimental);
                    $offset = $mid * 0.00_05;

                    $matrix[$i] = new Interval($mid - $offset, $mid + $offset);
                    // $matrix[$i] = $intervalExperimental;
                }
            }

            self::$calculatedData = $matrix;

            // dd($i, $j, $matrix);
        }

        return $matrix;
    }

    /**
     * @inheritDoc
     */
    public function expr()
    {
        return $this->config->get('parametric.bee_colony.structure');
    }

    /* public function exprNative(...$vars)
    {
        extract($vars);

        return p(p(p(p($g1, m($g2, W('i-1'))), m($g3, W('i-2'))), m($g4, W('i-3'))), m($g5, W('i-4')));
        // return p(p(p($g1, m($g2, W('i-1'))), m($g3, W('i-2'))), m($g4, W('i-3')));
    } */

    /**
     * @return array
     */
    public function variables(): array
    {
        $vars = [];
        $coordinates = $this->configNode->get('coordinates');

        foreach ($coordinates as $i => $name) {
            $vars[$name] = $this->coordinateValue($i + 1);
        }

        return $vars;
    }

    /**
     * @param int $coordinateKey
     * @return float|int
     */
    private function coordinateValue(int $coordinateKey)
    {
        return $this->point
            ->coordinates()
            ->get($coordinateKey)
            ->value();
    }
}
