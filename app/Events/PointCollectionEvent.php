<?php
declare(strict_types=1);

namespace App\Events;

use App\Models\MathGen\Point\Collection;
use App\Models\MathGen\Point\Point;

class PointCollectionEvent extends Event
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * Create a new event instance.
     *
     * @param Collection $collection
     * @param null $key
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->collection;
    }
}
