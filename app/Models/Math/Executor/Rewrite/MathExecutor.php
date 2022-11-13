<?php

declare(strict_types=1);

namespace App\Models\Math\Executor\Rewrite;

use App\Models\Math\Executor\Config;
use NXP\Exception\MathExecutorException;
use NXP\MathExecutor as MathExecutorBase;

class MathExecutor extends MathExecutorBase
{
    /**
     * Get the default operators
     *
     * @return array of class names
     */
    protected function defaultOperators(): array
    {
        $defaultConfig = parent::defaultOperators();
        $configObj = new Config;

        $config = array_merge(
            $defaultConfig,
            $configObj->operators()
        );

        return $config;
    }

    /**
     * Gets the default functions as an array. Key is function name
     * and value is the function as a closure.
     *
     * @return array
     */
    protected function defaultFunctions(): array
    {
        $defaultConfig = parent::defaultFunctions();
        $configObj = new Config;

        $config = array_merge(
            $defaultConfig,
            $configObj->functions()
        );

        return $config;
    }

    /**
     * Returns the default variables names as key/value pairs
     *
     * @return array
     */
    protected function defaultVars(): array
    {
        return parent::defaultVars();
    }

    /**
     * Add variable to executor
     *
     * @param  string $variable
     * @param  integer|float $value
     * @return MathExecutor
     */
    /*public function setVar(string $variable, $value) : self
    {
        try {
            return parent::setVar($variable, $value);
        } catch (MathExecutorException $e) {
            $this->variables[$variable] = $value;
        }
        if (!is_scalar($value) && $value !== null) {
            $type = gettype($value);
            throw new MathExecutorException("Variable ({$variable}) type ({$type}) is not scalar");
        }

        $this->variables[$variable] = $value;
        return $this;
    }*/
}
