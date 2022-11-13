<?php
declare(strict_types=1);

namespace App\Models\Logger\Source;

use App\Models\MathGen\Parametric\BeeColony\Identification;
use App\Models\MathGen\Point\Collection;

class PointCollectionSource extends Source
{
    const TOP_COUNT = 5;

    protected string $name = 'point_collection';

    /**
     * @var Collection
     */
    private $collection;

    private static array $top = [];

    /**
     * PointCollectionSource constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function prepare(): array
    {
        $data = [];
        $data['separator_before_top'] = [PHP_EOL];
        $data = array_merge($data, $this->topPoints());
        $data['separator_after_top'] = [PHP_EOL];
        $data['header'] = ['Bee', 'Delta', 'Fails', 'Coordinates'];
        $data = array_merge($data, $this->currentPoints());

        return $data;
    }

    private function currentPoints(): array
    {
        $data = [];
        foreach ($this->collection->all() as $point) {
            $data['l' . $point->key()] = array_merge($point->toArray(), [
                'delta' => round($point->delta()->value(), 5),
                'coordinates' => (string) $point->coordinates()
            ]);
        }

        return $data;
    }

    private function topPoints(): array
    {
        $points = collect(self::$top)
            ->merge($this->currentPoints())
            ->unique('delta')
            ->sortBy('delta')
            ->slice(0, self::TOP_COUNT);

        // Prepare the top points
        self::$top = [];
        $n = 1;
        foreach ($points as $point) {
            unset($point['fails']);
            $point['key'] = 'TOP-' . $n++;
            $point['mcn'] = $point['mcn'] ?? Identification::$mcnCurrent;
            self::$top[$point['key']] = $point;
        }

        return self::$top;
    }
}
