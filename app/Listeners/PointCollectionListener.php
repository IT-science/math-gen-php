<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\PointCollectionEvent;
use App\Models\Logger\Logger;
use App\Models\Logger\Source\PointCollectionSource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PointCollectionListener
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logger = Logger::getInstance();
    }

    /**
     * Handle the event.
     *
     * @param PointCollectionEvent $event
     * @return void
     */
    public function handle(PointCollectionEvent $event)
    {
        $source = new PointCollectionSource($event->collection());
        $this->logger->addSource($source);
    }
}
