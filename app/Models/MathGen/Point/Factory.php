<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point;

use App\Models\MathGen\Point\Coordinate\GeneratorInterface;
use App\Models\MathGen\Point\Delta\Factory as DeltaFactory;

class Factory
{
    /**
     * @var GeneratorInterface
     */
    private $generator;

    /**
     * @var DeltaFactory
     */
    private $deltaFactory;

    /**
     * Factory constructor.
     * @param GeneratorInterface $generator
     * @param DeltaFactory $deltaFactory
     */
    public function __construct(GeneratorInterface $generator, DeltaFactory $deltaFactory)
    {
        $this->generator = $generator;
        $this->deltaFactory = $deltaFactory;
    }

    /**
     * @param int $count
     * @return Collection
     */
    public function make(int $count): Collection
    {
        // $state = State::getInstance();
        $collection = new Collection;

        for ($pointKey = 1; $pointKey <= $count; $pointKey++) {
            // $state->setPointKey($l);
            $point = $this->one($pointKey);
            $collection->add($point);
        }

        return $collection;
    }

    /**
     * @param int $pointKey
     * @return Point
     */
    public function one(int $pointKey): Point
    {
        // $state = State::getInstance();
        $coordinates = $this->generator
            ->setPointKey($pointKey)
            ->execute();

        $point = new Point($pointKey, $coordinates);

        $delta = $this->deltaFactory->one($point);
        $point->setDelta($delta);

        return $point;
    }
}
