<?php

declare(strict_types=1);

namespace App\Models\Math\Executor;

use App\Models\Math\Executor\Func\CalculatedData1;
use App\Models\Math\Executor\Func\CreateInterval;
use App\Models\Math\Executor\Func\CalculatedData;
use App\Models\Math\Executor\Func\IntervalIntersection;
use App\Models\Math\Executor\Func\IntervalMiddle;
use App\Models\Math\Executor\Func\IntervalWidth;
use App\Models\Math\Executor\Func\Random;
use App\Models\Math\Executor\Func\RandomFloat;
use App\Models\Math\Executor\Operator\Minus;
use App\Models\Math\Executor\Operator\Obelus;
use App\Models\Math\Executor\Operator\Plus;
use App\Models\Math\Executor\Operator\Times;

class Config implements ConfigInterface
{
    /**
     * List of executor functions
     * @return \Closure[]
     */
    public function functions(): array
    {
        return [
            Random::NAME => function ($min, $max) {
                return (new Random($min, $max))->execute();
            },
            RandomFloat::NAME => function ($min, $max) {
                return (new RandomFloat($min, $max))->execute();
            },
            CreateInterval::NAME => function ($interval) {
                return (new CreateInterval($interval))->execute();
            },
            IntervalWidth::NAME => function ($interval) {
                return (new IntervalWidth($interval))->execute();
            },
            IntervalMiddle::NAME => function ($interval) {
                return (new IntervalMiddle($interval))->execute();
            },
            IntervalIntersection::NAME => function ($intervalA, $intervalB) {
                return (new IntervalIntersection($intervalA, $intervalB))->execute();
            },
            CalculatedData::NAME => function ($i, $j) {
                return (new CalculatedData($i, $j))->execute();
            },
            CalculatedData1::NAME => function ($i) {
                return (new CalculatedData1($i))->execute();
            },
        ];
    }

    /**
     * List of executor operators
     * @return array[]
     */
    public function operators(): array
    {
        return [
            Plus::OPERATOR => [
                function ($a, $b) {
                    return (new Plus($a, $b))->execute();
                },
                Plus::PRIORITY,
                Plus::IS_RIGHT_ASSOC
            ],
            Minus::OPERATOR => [
                function ($a, $b) {
                    return (new Minus($a, $b))->execute();
                },
                Minus::PRIORITY,
                Minus::IS_RIGHT_ASSOC
            ],
            Times::OPERATOR => [
                function ($a, $b) {
                    return (new Times($a, $b))->execute();
                },
                Times::PRIORITY,
                Times::IS_RIGHT_ASSOC
            ],
            Obelus::OPERATOR => [
                function ($a, $b) {
                    return (new Obelus($a, $b))->execute();
                },
                Obelus::PRIORITY,
                Obelus::IS_RIGHT_ASSOC
            ],
        ];
    }

    /**
     * List of executor operators
     * @return array
     */
    public function variables(): array
    {
        return [];
    }
}
