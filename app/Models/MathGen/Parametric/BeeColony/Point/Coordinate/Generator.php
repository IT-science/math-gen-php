<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Point\Coordinate;

use App\Models\Config\Config;
use App\Models\MathGen\Parametric\BeeColony\Config\Coordinates;
use App\Models\MathGen\Parametric\BeeColony\Config\Limits;
use App\Models\MathGen\Parametric\BeeColony\Expr\PointSeeker;
use App\Models\MathGen\Point\Coordinate\Generator as GeneratorBase;
use App\Models\MathGen\Point\Coordinate\Collection as CoordinateCollection;
use App\Models\MathGen\Point\Coordinate\Coordinate;

class Generator extends GeneratorBase
{
    /**
     * @var
     */
    private $expr;

    /**
     * @return CoordinateCollection
     */
    public function execute(): CoordinateCollection
    {
        $collection = new CoordinateCollection;
        $config = Config::getInstance();
        $coordinates = (new Coordinates)->get();
        $limits = (new Limits)->get();

        $key = 1;
        foreach ($coordinates as $name) {
            [$min, $max] = $limits[$name];

            $this->expr
                ->setMin($min)
                ->setMax($max);

            if ($this->expr instanceof PointSeeker) {
                $this->expr
                    ->setPointKey($this->pointKey())
                    ->setCoordinateKey($key);
            }

            $value = $this->expr->execute();

            $collection->add(new Coordinate($key, $name, $value));
            $key++;
        }

        return $collection;
    }

    /**
     * @param mixed $expr
     * @return Generator
     */
    public function setExpr($expr): self
    {
        $this->expr = $expr;
        return $this;
    }
}
