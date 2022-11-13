<?php

use App\Models\Math\Executor\Func\CalculatedData;
use App\Models\Math\Executor\Func\CalculatedData1;
use App\Models\Math\Executor\Func\RandomFloat;
use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Operation\OperationRunner;

if (! function_exists('randf')) {
    function randf($min, $max)
    {
        return (new RandomFloat($min, $max))->execute();
    }
}

if (! function_exists('mid')) {
    function mid(Interval $interval)
    {
        return (new OperationRunner('middle'))
            ->addInterval($interval)
            ->execute();
    }
}

if (! function_exists('wid')) {
    function wid(Interval $interval)
    {
        return (new OperationRunner('width'))
            ->addInterval($interval)
            ->execute();
    }
}

if (! function_exists('intersect')) {
    function intersect(Interval $intervalA, Interval $intervalB)
    {
        return (new OperationRunner('intersection'))
            ->addInterval($intervalA)
            ->addInterval($intervalB)
            ->execute();
    }
}

if (! function_exists('v')) {
    function v($i, $j)
    {
        return (new CalculatedData($i, $j))->execute();
    }
}

if (! function_exists('w')) {
    function w($i)
    {
        return (new CalculatedData1($i))->execute();
    }
}

if (! function_exists('m')) {
    function m($a, $b)
    {
        if ($a instanceof Interval || $b instanceof Interval) {
            return (new OperationRunner('multiplication'))
                ->addInterval($a instanceof Interval ? $a : new Interval($a))
                ->addInterval($b instanceof Interval ? $b : new Interval($b))
                ->execute();
        }

        return $a * $b;
    }
}

if (! function_exists('p')) {
    function p($a, $b)
    {
        if ($a instanceof Interval || $b instanceof Interval) {
            return (new OperationRunner('addition'))
                ->addInterval($a instanceof Interval ? $a : new Interval($a))
                ->addInterval($b instanceof Interval ? $b : new Interval($b))
                ->execute();
        }

        return $a + $b;
    }
}
