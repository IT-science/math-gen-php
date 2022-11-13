<?php
declare(strict_types=1);

namespace App\Models\Logger;

use App\Models\Logger\Channel\ChannelInterface;
use App\Models\Logger\Source\SourceInterface;

class Logger implements LoggerInterface
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var SourceInterface[]
     */
    private $sources = [];

    /**
     * @var ChannelInterface[]
     */
    private $channels = [];

    /**
     * Config constructor.
     */
    private function __construct()
    {

    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    protected function addData($data): self
    {
        foreach ($this->channels as $channel) {
            $channel->write($data);
        }

        return $this;
    }

    /**
     * @param SourceInterface $source
     * @return $this
     */
    public function addSource(SourceInterface $source): self
    {
        $this->sources[$source->name()] = $source;
//        $this->go();
        return $this;
    }

    /**
     * @param ChannelInterface $channel
     * @return $this
     */
    public function addChanel(ChannelInterface $channel): self
    {
        $this->channels[$channel->name()] = $channel;
        return $this;
    }

    /**
     * @return $this
     */
    public function go(): self
    {
        foreach ($this->sources as $source) {
            $data = $source->prepare();
            $this->addData($data);
        }

        return $this;
    }
}
