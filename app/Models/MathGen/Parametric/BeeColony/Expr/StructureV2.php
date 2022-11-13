<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\Math\Interval\Interval;
use App\Models\MathGen\Point\Point;

class StructureV2 extends Expression
{
    public static array $calculatedData = [];
    public static int $i = 0;
    public static int $j = 0;

    public $useIntervals = false;

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

        $I = count($experimentalData['nums']) - 1;
        $J = count($experimentalData['nums'][0]) - 1;

        $iStart = 1;
        $jStart = 3;

        $matrix = [];

        foreach (range(0, $I) as $i) {
            foreach (range(0, $J) as $j) {
                self::$i = $i;
                self::$j = $j;

                if ($i >= $iStart && $j >= $jStart) {
                    $matrix[$i][$j] = parent::execute();
                }
                /**
                 * Calculate mid(experimentalInterval) * 0.0005 if structure is out of matrix
                 */
                else {
                    if ($this->useIntervals) {
                        $left = $experimentalData['left'][$i][$j];
                        $right = $experimentalData['right'][$i][$j];
                        $intervalExperimental = new Interval($left, $right);
                        $mid = mid($intervalExperimental);
                        $offset = $mid * 0.00_05;

                        $matrix[$i][$j] = new Interval($mid - $offset, $mid + $offset);
                    } else {
                        $z = $experimentalData['nums'][$i][$j];
                        $intervalExperimental = new Interval($z, $z);
                        $matrix[$i][$j] = $intervalExperimental;

                        // $matrix[$i][$j] = $z;
                    }
                }

                self::$calculatedData = $matrix;

                // dd($i, $j, $matrix);
            }
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

    /*public function exprNative(...$vars)
    {
        return p(p(p(m($g2, V('i', 'j-1')), )))
    }*/

    /* public function exprNative3(...$vars)
    {
        extract($vars);
        // return p(p(p(p(p(p(p($g1, m($g2, V('i-1', 'j'))), m($g3, V('i', 'j-1'))), m($g4, V('i-1', 'j-1'))), m($g5, V('i-2', 'j'))), m(m($g6, V('i-1', 'j-1')), V('i-1', 'j'))), m($g7, V('i-2', 'j'))), m($g8, V('i-3', 'j')));
        // return p(p(p(p(p(p(p($g1, m($g2, V('i', 'j-1'))), m($g3, V('i-1', 'j'))), m($g4, V('i-1', 'j-1'))), m($g5, V('i', 'j-2'))), m(m($g6, V('i-1', 'j-1')), V('i', 'j-1'))), m($g7, V('i', 'j-2'))), m($g8, V('i', 'j-3')));

        // return ((p(p(p(p(p($g1, m($g2, V('i-1', 'j'))), m($g3, V('i', 'j-1'))), m($g4, V('i-1', 'j-1'))), m($g5, V('i-2', 'j'))), m(m($g6, V('i-1', 'j-1')), V('i-1', 'j')))));
        // return ((p(p(p(p(p($g1, m($g2, V('i', 'j-1'))), m($g3, V('i-1', 'j'))), m($g4, V('i-1', 'j-1'))), m($g5, V('i', 'j-2'))), m(m($g6, V('i-1', 'j-1')), V('i', 'j-1')))));

        // return p(p(p(p(p(p($g1, m($g2, V('i', 'j-1'))), m($g3, V('i-1', 'j'))), m($g4, V('i-1', 'j-1'))), m($g5, V('i', 'j-2'))), m($g7, V('i', 'j-2'))), m($g8, V('i', 'j-3')));

        return p(p(p(p(p($g1, m($g2, V('i', 'j-1'))), m($g3, V('i-1', 'j'))), m($g4, V('i-1', 'j-1'))), m($g5, V('i', 'j-2'))), m($g8, V('i', 'j-3')));
        // return p(p(p(p(p($g1, m($g2, V('i-1', 'j'))), m($g3, V('i', 'j-1'))), m($g4, V('i-1', 'j-1'))), m($g5, V('i-2', 'j'))), m($g8, V('i-3', 'j')));

            // return p(p(p(p(p($g1, m($g2, V('i', 'j-1'))), m($g3, V('i-1', 'j'))), m($g5, V('i', 'j-2'))), m($g7, V('i', 'j-2'))), m($g8, V('i', 'j-3')));

        // return (p(p(p(p($g1, m($g2, V('i', 'j-1'))), m($g3, V('i-1', 'j'))), m($g4, V('i-1', 'j-1'))), m($g5, V('i', 'j-2'))));
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
