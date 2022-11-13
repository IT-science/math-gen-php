<?php

namespace App\Models\Math\Executor;

interface ExecutorInterface
{
    /**
     * @param string $expression
     * @return mixed
     */
    public function execute(string $expression);
}
