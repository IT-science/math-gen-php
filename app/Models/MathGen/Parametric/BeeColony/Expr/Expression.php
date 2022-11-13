<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\Config\Config;
use App\Models\Math\Executor\Executor;
use App\Models\Config\NodeInterface;
use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Operation\IsEqual;
use App\Models\MathGen\Parametric\BeeColony\Identification;

abstract class Expression
{
    protected Config $config;
    protected NodeInterface $configNode;

    /**
     * @var Executor
     */
    protected $executor;

    /**
     * @var bool
     */
    protected $checkNativeResult = true;

    /**
     * Expression constructor.
     */
    public function __construct()
    {
        $this->config = Config::getInstance();
        $this->configNode = $this->config->node('parametric.bee_colony');

        $this->executor = new Executor;
    }

    /**
     * @return number
     * @throws \NXP\Exception\IncorrectBracketsException
     * @throws \NXP\Exception\IncorrectExpressionException
     * @throws \NXP\Exception\UnknownOperatorException
     * @throws \NXP\Exception\UnknownVariableException
     */
    public function execute()
    {
        $vars = $this->variables();

        $result = $resultByNative = null;
        if (method_exists($this, 'exprNative')) {
            $resultByNative = $this->exprNative(...$vars);
        }

        if (null === $resultByNative
            || Identification::$mcnCurrent <= 10
            || Identification::$mcnCurrent % 100 === 0
        ) {
            foreach ($vars as $name => $value) {
                $this->executor->unwrap()->setVar($name, (string) $value);
            }

            if (is_array($this->expr())) {
                foreach ($this->expr() as $expr) {
                    $result = $this->executor->execute($expr);
                }
            } else {
                $result = $this->executor->execute($this->expr());
            }
        }

        if ($this->checkNativeResult && null !== $result && null !== $resultByNative) {
            $isEqual = true;
            if ($result instanceof Interval && $resultByNative instanceof Interval) {
                $isEqual = (new IsEqual)
                    ->addInterval($result)
                    ->addInterval($resultByNative)
                    ->execute();
            } elseif ($result !== $resultByNative) {
                $isEqual = false;
            }

            if (! $isEqual) {
                dd('Result and ResultByNative are different', $result, $resultByNative /*, $this->intervalCalculated, $this->intervalExperimental*/);
                throw new \Exception('Result and ResultByNative are different');
            }
        }

        if (null === $result && null !== $resultByNative) {
            $result = $resultByNative;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function variables(): array
    {
        return [];
    }

    /**
     * @return mixed
     */
    abstract public function expr();
}
