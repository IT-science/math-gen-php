<?php
declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Expr;

use App\Models\MathGen\Point\Collection;
use App\Models\MathGen\Point\Point;

class NormalizeDelta extends Expression
{
    /**
     * @var Point
     */
    private $currentPoint;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @param Point $currentPoint
     * @param Collection $collection
     */
    public function __construct(Point $currentPoint, Collection $collection)
    {
        parent::__construct();
        $this->currentPoint = $currentPoint;
        $this->collection = $collection;
    }

    /**
     * @inheritDoc
     */
    public function expr()
    {
        return '(delta - minDelta) / (maxDelta - minDelta)';
    }

    /**
     * @inheritDoc
     */
    public function variables(): array
    {
        $deltas = $this->collection->pluck('delta');

        return [
            'delta' => $this->currentPoint->delta()->value(),
            'minDelta' => min($deltas),
            'maxDelta' => max($deltas),
        ];
    }
}
