<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

use App\Models\Config\Config;
use App\Models\Math\Interval\Interval;
use App\Models\MathGen\Parametric\BeeColony\Expr\Structure1;

class CalculatedData1 implements FunctionInterface
{
    /**
     * Function name in executor
     */
    const NAME = 'W';

    /**
     * @var string
     */
    private $i;

    /**
     * CreateInterval constructor.
     * @param string $interval
     */
    public function __construct(string $i)
    {
        $this->i = $i;
    }

    /**
     * @return Interval
     */
    public function execute(): Interval
    {
        $iCurrent = Structure1::$i;

        $iCond = (int) str_replace('i', '', $this->i);

        $i = $iCurrent + $iCond;

        if ($i < 0) {
            dd('Out of matrix', $i);
            /*$experimentalData = Config::getInstance()->get('parametric.bee_colony.experimental_data');
            $left = $experimentalData['left'][$i][$j];
            $right = $experimentalData['right'][$i][$j];
            $intervalExperimental = new Interval($left, $right);
            mid($intervalExperimental)
            $result = new Interval($experimentalData['start'], 0);
            $result = $intervalExperimental;*/
        }

        if (isset(Structure1::$calculatedData[$i])) {
            $result = Structure1::$calculatedData[$i];
        } else {
            dd('Out of matrix');
        }

        // if ($iCurrent === 1 && $jCurrent === 1)
        // dd($iCurrent, $jCurrent, $iCond, $jCond, $i, $j, $result, Structure2::$calculatedData);
        
        return $result;
    }
}
