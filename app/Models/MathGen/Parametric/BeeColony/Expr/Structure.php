<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\MathGen\Point\Point;

class Structure extends Expression
{
    /**
     * @var Point
     */
    private $point;

    public function __construct(Point $point)
    {
        parent::__construct();

        $this->point = $point;
    }

    /**
     * @return array
     */
    public function execute()
    {
        $K = count($this->config->get('parametric.bee_colony.experimental_data')) - 1;
        $exprInitial = $this->config->get('parametric.bee_colony.expr_initial');
        $intervals = [];

        foreach ($exprInitial as $expr) {
            $intervals[] = $this->executor->execute($expr);
        }

        foreach (range(2, $K) as $k) {
            $this->executor->unwrap()
                ->setVar('prev1', (string) $intervals[$k - 1])
                ->setVar('prev2', (string) $intervals[$k - 2]);

            $intervals[] = parent::execute();
        }

        return $intervals;
    }

    /**
     * @inheritDoc
     */
    public function expr()
    {
        return $this->config->get('parametric.bee_colony.structure');
    }

    /**
     * @return array
     */
    public function variables(): array
    {
        $vars = [];
        $coordinates = $this->configNode->get('coordinates');

        foreach ($coordinates as $i => $name) {
            $vars[$name] = $this->coordinateValue($i + 1);
        }

        return $vars;
    }

    /**
     * @param int $coordinateKey
     * @return float|int
     */
    private function coordinateValue(int $coordinateKey)
    {
        return $this->point
            ->coordinates()
            ->get($coordinateKey)
            ->value();
    }
}
