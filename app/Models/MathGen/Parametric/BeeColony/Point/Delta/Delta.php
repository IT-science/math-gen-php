<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Point\Delta;

use App\Models\Config\Config;
use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Operation\IsCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\DeltaCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\DeltaNotCrossed;
use App\Models\MathGen\Parametric\BeeColony\Expr\Structure;
use App\Models\MathGen\Point\Delta\Delta as BaseDelta;

class Delta extends BaseDelta
{
    /**
     * @inheritDoc
     */
    protected function calculate()
    {
        $allDeltas = [];
        $config = Config::getInstance()->node('parametric.bee_colony');
        $experimentalData = $config->get('experimental_data');
        $experimentalIntervalKey = $config->get('experimental_data_interval_key');
        $intervals = (new Structure($this->point()))->execute();

        foreach ($intervals as $key => $intervalCalculated) {
            [$left, $right] = $experimentalData[$key][$experimentalIntervalKey];
            $intervalExperimental = new Interval($left, $right);

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
        }

        return max($allDeltas);
    }
}
