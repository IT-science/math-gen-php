<?php

namespace App\Models\Math\Executor;

interface ExpressionInterface
{
    /**
     * @return string
     */
    public function expression(): string;

    /**
     * @return string|null
     */
    public function variable(): ?string;
}
