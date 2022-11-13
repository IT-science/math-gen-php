<?php

declare(strict_types=1);

namespace App\Models\Math\Executor;

use App\Models\Math\Executor\Rewrite\MathExecutor as MathExecutorRewrite;
use NXP\MathExecutor;

class Executor implements ExecutorInterface
{
    /**
     * @var MathExecutor
     */
    private $executor;

    /**
     * Executor constructor.
     */
    public function __construct()
    {
        $this->executor = new MathExecutorRewrite;
    }

    /**
     * @param string $expression
     * @return number
     * @throws \NXP\Exception\IncorrectBracketsException
     * @throws \NXP\Exception\IncorrectExpressionException
     * @throws \NXP\Exception\UnknownOperatorException
     * @throws \NXP\Exception\UnknownVariableException
     */
    public function execute(string $expression)
    {
        $expr = new Expression($expression);
        $result = $this->executor->execute($expr->expression());

        if ($var = $expr->variable()) {
            $this->executor->setVar($var, $result);
        }

        return $result;
    }

    /**
     * @return MathExecutor
     */
    public function unwrap()
    {
        return $this->executor;
    }
}
