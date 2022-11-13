<?php

namespace App\Models\Math\Interval;

interface IntervalInterface
{
    /**
     * @return numeric
     */
    public function left();

    /**
     * @return numeric
     */
    public function right();

    /**
     * @return mixed
     */
    public function asArray();

    /**
     * @return mixed
     */
    public function asString();
}
