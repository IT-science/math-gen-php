<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point\Coordinate;

use Illuminate\Contracts\Support\Arrayable;

class Collection implements Arrayable
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private $items;

    /**
     * Collection constructor.
     */
    public function __construct()
    {
        $this->items = collect();
    }

    /**
     * @param Coordinate $coordinate
     * @return $this
     */
    public function add(Coordinate $coordinate): self
    {
        $this->items->put($coordinate->key(), $coordinate);
        return $this;
    }

    /**
     * @param $key
     * @return Coordinate
     */
    public function get(int $key): Coordinate
    {
        return $this->items->get($key);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->items->toArray();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        // The "pluck" method can't get values from object if the property isn't public
        $data = [];
        foreach ($this->items->all() as $coordinate) {
            $data[] = round((float) $coordinate->value(), 6);
        }

        return join(', ', $data);
    }
}
