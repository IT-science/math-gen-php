<?php
declare(strict_types=1);

namespace App\Models\Logger\Channel;

use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;

class Console extends Channel
{
    protected string $name = 'console';

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var ConsoleSectionOutput[]
     */
    private $sections = [];

    /**
     * @var int
     */
    private $lazyPeriod = 0;

    /**
     * @var int
     */
    private $lazyTime = null;

    /**
     * Console constructor.
     * @param OutputInterface|null $output
     */
    public function __construct(OutputInterface $output = null)
    {
        $this->output = $output ?: new ConsoleOutput;
    }

    /**
     * @param $data
     * @return $this
     */
    public function write($data): ChannelInterface
    {
        /*if ($this->lazy()) {
            return $this;
        }*/

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $sectionName = 'section-' . $key;
                $section = $this->section($sectionName);
                $section->overwrite(join(' | ', $value));
            }
        } else {
            $this->output->writeln($data);
        }

        return $this;
    }

    /**
     * @param string $name
     * @return ConsoleSectionOutput
     */
    public function section(string $name): ConsoleSectionOutput
    {
        if (empty($this->sections[$name])) {
            $this->sections[$name] = $this->output->section();
        }

        return $this->sections[$name];
    }

    /**
     * @return bool
     */
    private function lazy(): bool
    {
        $lazy = true;
        if (! $this->lazyTime || $this->lazyTime < time()) {
            $this->lazyTime = time() + $this->lazyPeriod;
            $lazy = false;
        }

        return $lazy;
    }
}
