<?php
declare(strict_types=1);

namespace App\Models\Logger\Source;

use Illuminate\Support\Carbon;

class ProgressSource extends Source
{
    protected string $name = 'progress';
    private int $mcn = 1;
    private int $localMinima = 0;
    private Carbon $startTime;

    public function __construct()
    {
        $this->startTime = Carbon::now();
    }

    /**
     * @inheritDoc
     */
    public function prepare()
    {
        return [
            'progress' => [
                'MCN: ' . $this->mcn,
                'Local Minimums: ' . $this->localMinima,
            ],
            'time' => [
                'Time: ' . $this->totalTime(),
                'Per MCN: ' . $this->mcnTime(),
            ],
        ];
    }

    /**
     * @param int $mcn
     * @return ProgressSource
     */
    public function setMcn(int $mcn): ProgressSource
    {
        $this->mcn = $mcn;
        return $this;
    }

    /**
     * @return ProgressSource
     */
    public function incrementLocalMinima(): ProgressSource
    {
        $this->localMinima++;
        return $this;
    }

    /**
     * @return string
     */
    private function totalTime(): string
    {
        return (string) (new Carbon)->diffInSeconds($this->startTime);
//        return (new Carbon)->diffForHumans($this->startTime);
    }

    /**
     * @return float
     */
    private function mcnTime(): float
    {
        $sec = (new Carbon)->diffInSeconds($this->startTime);
        return  round($sec / $this->mcn, 5);
    }
}
