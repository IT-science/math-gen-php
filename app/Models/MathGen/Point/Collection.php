<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point;

use App\Events\PointCollectionEvent;
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
     * @param Point $point
     * @return $this
     */
    public function add(Point $point): self
    {
        $this->items->put($point->key(), $point);
        $this->onUpdate();
        return $this;
    }

    /**
     * @param Point $point
     * @param int|null $key
     * @return $this
     */
    public function replace(Point $point, int $key = null): self
    {
        $this->add($point);
        return $this;
    }

    /**
     * @param int $key
     * @return Point
     */
    public function get(int $key): Point
    {
        return $this->items->get($key);
    }

    /**
     * @param int $key
     * @return $this
     */
    public function remove(int $key): self
    {
        $this->items->forget($key);
        $this->onUpdate();
        return $this;
    }

    /**
     * @return Point[]
     */
    public function all(): array
    {
        return $this->items->all();
    }

    /**
     * @param string $name
     * @return array
     */
    public function pluck(string $name): array
    {
        return array_column($this->items->toArray(), $name);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->items->count();
    }

    /**
     * @return Point
     */
    public function random(): Point
    {
        return $this->items->random();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items->toArray();
    }

    /**
     * Clone collection
     */
    public function __clone()
    {
        $this->items = clone $this->items;
    }

    /**
     * Trigger event
     */
    private function onUpdate()
    {
        event(new PointCollectionEvent($this));
    }
}
