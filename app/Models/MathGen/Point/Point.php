<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point;

use App\Models\MathGen\Point\Coordinate\Collection as Coordinates;
use App\Models\MathGen\Point\Delta\DeltaInterface;
use Illuminate\Contracts\Support\Arrayable;

class Point implements Arrayable
{
    /**
     * The "l" parameter in math models
     * e.g. l = 1, ..., S
     *
     * @var int
     */
    private $key;

    /**
     * @var Coordinates
     */
    private $coordinates;

    /**
     * @var DeltaInterface
     */
    private $delta;

    /**
     * @var int
     */
    private $fails = 0;

    /**
     * Point constructor.
     * @param int $key
     * @param Coordinates $coordinates
     */
    public function __construct(int $key, Coordinates $coordinates)
    {
        $this->key = $key;
        $this->coordinates = $coordinates;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * @return Coordinates
     */
    public function coordinates(): Coordinates
    {
        return $this->coordinates;
    }

    /**
     * @return DeltaInterface
     */
    public function delta(): DeltaInterface
    {
        return $this->delta;
    }

    /**
     * @param DeltaInterface $delta
     * @return $this
     */
    public function setDelta(DeltaInterface $delta): self
    {
        $this->delta = $delta;
        return $this;
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function hasBetterDelta(Point $point): bool
    {
        return $this->delta()->value() < $point->delta()->value();
    }

    /**
     * @return int
     */
    public function fails(): int
    {
        return $this->fails;
    }

    /**
     * @return $this
     */
    public function incrementFails(): self
    {
        $this->fails++;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key(),
            'delta' => $this->delta()->value(),
            'fails' => $this->fails(),
            'coordinates' => $this->coordinates(),
        ];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->key . ', d: ' . (int) $this->delta->value() . ' [' . $this->coordinates() . ']';
    }
}
