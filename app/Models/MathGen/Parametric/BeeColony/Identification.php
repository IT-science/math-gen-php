<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony;

use App\Models\Config\Config;
use App\Models\Config\NodeInterface;
use App\Models\Logger\Logger;
use App\Models\Logger\Source\ProgressSource;
use App\Models\MathGen\Parametric\BeeColony\Expr\CheckNearPoints;
use App\Models\MathGen\Parametric\BeeColony\Expr\PointSeeker;
use App\Models\MathGen\Parametric\BeeColony\Expr\PointSeekerInitial;
use App\Models\MathGen\Parametric\BeeColony\Point\Coordinate\Generator;
use App\Models\MathGen\Parametric\BeeColony\Point\Delta\Delta;
use App\Models\MathGen\Parametric\BeeColony\Point\Delta\Delta1;
use App\Models\MathGen\Parametric\BeeColony\Point\Delta\Delta2;
use App\Models\MathGen\Parametric\BeeColony\Point\Delta\DeltaV2;
use App\Models\MathGen\Point\Factory;
use App\Models\MathGen\Point\Delta\Factory as DeltaFactory;

use App\Models\MathGen\Point\Point;
use App\Models\MathGen\Point\Collection;
use App\Models\MathGen\Point\Coordinate\Coordinate;
use App\Models\MathGen\Point\Coordinate\Collection as Coordinates;

class Identification
{
    public static $mcnCurrent = 0;

    private NodeInterface $config;
    private int $countBees;
    private int $mcn;
    private int $failsLimit;

    private string $deltaClass;

    private Logger $logger;
    private ProgressSource $progress;

    public function __construct()
    {
        $this->config = Config::getInstance()->node('parametric.bee_colony');
        $this->countBees = $this->config->get('count_bees');
        $this->mcn = $this->config->get('MCN');
        $this->failsLimit = $this->config->get('fails_limit');

        $deltaClass = 'Delta';
        if ($this->config->has('delta_class')) {
            $deltaClass = $this->config->get('delta_class', $deltaClass);
        }

        $this->deltaClass = 'App\Models\MathGen\Parametric\BeeColony\Point\Delta\\' . $deltaClass;

        $this->logger = Logger::getInstance();
        $this->progress = new ProgressSource;
        $this->logger->addSource($this->progress);
    }

    public function execute()
    {
        $resultPoint = null;

        $generator = new Generator;
        $factory = new Factory($generator, new DeltaFactory($this->deltaClass));
        $factoryInitial = new Factory(
            (new Generator)->setExpr(new PointSeekerInitial),
            new DeltaFactory($this->deltaClass)
        );

        /**
         * Формуємо набір початкових значень
         */
        // Знаходження початкових точок по формулі 11
        $collectionInitial = $factoryInitial->make($this->countBees);

        // Формуємо ще 10 точок для селекції
        $generator->setExpr(new PointSeeker($collectionInitial));
        $collection = $factory->make($this->countBees);

        // Виконуємо попарну селекцію точок - обираємо одну із двох, дельта якої менша
        foreach ($collection->all() as $point) {
            $pointInitial = $collectionInitial->get($point->key());
            if ($pointInitial->hasBetterDelta($point)) {
                $collection->replace($pointInitial);
            }
        }

        /**
         * Run process
         */
        $generator->setExpr(new PointSeeker($collection));

        for ($mcn = 1; $mcn <= $this->mcn; $mcn++) {
            self::$mcnCurrent = $mcn;
            $this->progress->setMcn($mcn);

            foreach ($collection->all() as $point) {
                /**
                 * @todo Need to investigate why CheckNearPoints can return 0 for all points
                 */ 
                // Беремо точки в околах існуючих (може бути 0 і більше)
                $checkNearPoints = 1; // (new CheckNearPoints($point, $collection))->execute();

                if ($checkNearPoints > 0) {
                    foreach (range(1, (int) $checkNearPoints) as $n) {
                        $nearPoint = $factory->one($point->key());
                        // info([(string) $point, (string)$nearPoint]);

                        if ($nearPoint->hasBetterDelta($point)) {
                            $collection->replace($nearPoint);
                            // info('REPLACED!');
                        } else {
                            $point->incrementFails();
                        }
                    }
                } else {
                    $newPoint = $factoryInitial->one($point->key());
                    $collection->replace($newPoint);
                }

                // Заміняємо точки при досягненні локальних мінімумів
                $delta = $point->delta()->value();
                $failsLimit = $this->failsLimit;

                /* if ($delta <= 10) {
                    $failsLimit = 200;
                } elseif ($delta <= 50) {
                    $failsLimit = 100;
                } elseif ($delta <= 100) {
                    $failsLimit = 50;
                } */

                if ($point->fails() >= $failsLimit) {
                    $this->progress->incrementLocalMinima();
                    $newPoint = $factoryInitial->one($point->key());
                    $collection->replace($newPoint);
                }

                if (0 == $point->delta()->value()) {
                    $resultPoint = $point;
                    break(2);
                }
            }

            $this->logger->go();
        }

        return [
            'point' => $resultPoint,
            'mcn' => $mcn,
        ];
    }
}
