<?php

declare(strict_types=1);

namespace App\Models\Math\Executor;

class Expression implements ExpressionInterface
{
    /**
     * @var string
     */
    private $expression;

    /**
     * @var string|null
     */
    private $variable = null;

    /**
     * Expression constructor.
     * @param string $expression
     */
    public function __construct(string $expression)
    {
        $this->parse($expression);
    }

    /**
     * @return string
     */
    public function expression(): string
    {
        return $this->expression;
    }

    /**
     * @return string
     */
    public function variable(): ?string
    {
        return $this->variable;
    }

    /**
     * Split expression with variable name
     *
     * @param string $expression
     * @return $this
     */
    private function parse(string $expression): self
    {
        if (false !== strpos($expression, '=')) {
            [$var, $expression] = explode('=', $expression, 2);

            if ($var = trim($var)) {
                $this->variable = $var;
            }
        }

        $this->expression = trim($expression);

        return $this;
    }
}
