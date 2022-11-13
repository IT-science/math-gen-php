<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Point\Delta;

use App\Models\Config\Config;
use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Operation\IsCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\DeltaCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\DeltaNotCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\Structure2;
use App\Models\MathGen\Point\Delta\Delta as BaseDelta;

class Delta2 extends BaseDelta
{
    /**
     * @inheritDoc
     */
    protected function calculate()
    {
        $allDeltas = [];
        $config = Config::getInstance()->node('parametric.bee_colony');
        $experimentalData = $config->get('experimental_data');
        $calculatedData = (new Structure2($this->point()))->execute();

        foreach ($calculatedData as $i => $row) {
            foreach ($row as $j => $intervalCalculated) {
                $left = $experimentalData['left'][$i][$j];
                $right = $experimentalData['right'][$i][$j];
                $intervalExperimental = new Interval($left, $right);
                // if ($i === 15) dd($i, $j, $left, $right);
                // if ($intervalCalculated->left() !== $intervalCalculated->right())
                // dd($intervalCalculated->left(), $intervalCalculated->right());

                // try {
                $isCrossed = (new IsCrossed)
                    ->addInterval($intervalCalculated)
                    ->addInterval($intervalExperimental)
                    ->execute();

                if ($isCrossed) {
                    $allDeltas[] = (new DeltaCrossed($intervalCalculated, $intervalExperimental))
                        ->execute();
                } else {
                    $allDeltas[] = (new DeltaNotCrossed($intervalCalculated, $intervalExperimental))
                        ->execute();
                }
                /*} catch (\InvalidArgumentException $e) {
                    return 9999999;
                }*/
            }
        }

        return max($allDeltas);
    }
}
