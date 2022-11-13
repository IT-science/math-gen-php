<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Point\Delta;

use App\Models\Config\Config;
use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Operation\IsCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\Alpha;
use App\Models\MathGen\Parametric\BeeColony\Expr\DeltaCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\DeltaNotCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\StructureV2;
use App\Models\MathGen\Point\Delta\Delta as BaseDelta;

class DeltaV2 extends BaseDelta
{
    /**
     * @inheritDoc
     */
    protected function calculate()
    {
        $allDeltas = [];
        $config = Config::getInstance()->node('parametric.bee_colony');
        $experimentalData = $config->get('experimental_data');
        $calculatedData = (new StructureV2($this->point()))->execute();

        foreach ($calculatedData as $i => $row) {
            foreach ($row as $j => $intervalCalculated) {
                $v = $calculatedData[$i][$j]->left();
                $zLeft = $experimentalData['left'][$i][$j];
                $zRight = $experimentalData['right'][$i][$j];
                $alpha = new Alpha(function($a) use ($v, $zLeft, $zRight) {
                    return ($v - ($a * $zLeft + (1 - $a) * $zRight)) **2;
                });
                $alpha->find();

                $allDeltas[] = $alpha->minResult;
            }
        }

        return array_sum($allDeltas);
    }
}
