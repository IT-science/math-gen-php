<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Func;

use App\Models\Config\Config;
use App\Models\Math\Interval\Interval;
// use App\Models\MathGen\Parametric\BeeColony\Expr\Structure;
// use App\Models\MathGen\Parametric\BeeColony\Expr\Structure2;
use App\Models\MathGen\Parametric\BeeColony\Expr\StructureV2;

$structureClass = 'Structure2';
$config = Config::getInstance()->node('parametric.bee_colony');
if ($config->has('structure_class')) {
    $structureClass = $config->get('structure_class', $structureClass);
}

class_alias('App\Models\MathGen\Parametric\BeeColony\Expr\\' . $structureClass, 'StructureClass');

class CalculatedData implements FunctionInterface
{
    /**
     * Function name in executor
     */
    const NAME = 'V';

    /**
     * @var string
     */
    private $i;

    /**
     * @var string
     */
    private $j;

    /**
     * CreateInterval constructor.
     * @param string $interval
     */
    public function __construct(string $i, string $j)
    {
        $this->i = $i;
        $this->j = $j;
    }

    /**
     * @return Interval
     */
    public function execute(): Interval
    {
        $iCurrent = \StructureClass::$i;
        $jCurrent = \StructureClass::$j;

        $iCond = (int) str_replace('i', '', $this->i);
        $jCond = (int) str_replace('j', '', $this->j);

        $i = $iCurrent + $iCond;
        $j = $jCurrent + $jCond;

        if ($i < 0 || $j < 0) {
            dd('Out of matrix', $i, $j);
            /*$experimentalData = Config::getInstance()->get('parametric.bee_colony.experimental_data');
            $left = $experimentalData['left'][$i][$j];
            $right = $experimentalData['right'][$i][$j];
            $intervalExperimental = new Interval($left, $right);
            // mid($intervalExperimental)
            // $result = new Interval($experimentalData['start'], 0);
            $result = $intervalExperimental;*/
        }

        if (isset(\StructureClass::$calculatedData[$i][$j])) {
            $result = \StructureClass::$calculatedData[$i][$j];
        } else {
            dd('Out of matrix');
        }

        // if ($iCurrent === 1 && $jCurrent === 1)
        // dd($iCurrent, $jCurrent, $iCond, $jCond, $i, $j, $result, \StructureClass::$calculatedData);

        return $result;
    }
}
