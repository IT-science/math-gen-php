<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point\Stub;

//use App\Models\MathGen\Point\State;
use App\Models\MathGen\Point\Coordinate\Collection;
use App\Models\MathGen\Point\Coordinate\Coordinate;
use App\Models\MathGen\Point\Coordinate\Generator;

class GeneratorStub extends Generator
{
    /**
     * @return Collection
     */
    public function execute(): Collection
    {
        // $state = State::getInstance();
        $collection = new Collection;

        foreach (range(1, 2) as $key) {
            // $state->setCoordinateKey($key);
            $collection->add(new Coordinate($key, "g$key", rand(100, 999)));
        }

        return $collection;
    }
}
