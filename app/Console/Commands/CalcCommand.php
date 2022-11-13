<?php

namespace App\Console\Commands;

use App\Listeners\PointCollectionListener;
use App\Models\Config\Config;
use App\Models\Helper\Json;
use App\Models\Logger\Channel\Console;
use App\Models\Logger\Logger;
use App\Models\Math\Executor\Executor;
use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Operation\OperationRunner;
use App\Models\MathGen\Parametric\BeeColony\Identification;
use App\Models\MathGen\Point\Factory;
use App\Models\MathGen\Point\Stub\DeltaStub;
use App\Models\MathGen\Point\Stub\GeneratorStub;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\InputOption;
use App\Models\MathGen\Point\Delta\Factory as DeltaFactory;

/**
 * https://stackoverflow.com/questions/30251065/lumen-makecommand
 * https://stackoverflow.com/questions/52716203/laravel-lumen-framework5-7-and-flipbox-lumen-generator5-6-class-not-fou/52717071#52717071
 */
class CalcCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc {--json=}';

    /**
     * The console command name.
     *
     * @var string
     */
    // protected $name = 'calc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the input data';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Start');

        $file = $this->option('json');
        $filePath = resource_path('calc/' . $file . '.json');

        $jsonHelper = new Json;
        if (! $jsonHelper->readFile($filePath)) {
            $this->error('JSON file is not available');
            return;
        }

        $json = $jsonHelper->decode();

        switch ($json->type) {
            /**
             * Basic math operations
             */
            case 'basic':
                // no break

            /**
             * Math operations extended with intervals
             */
            case 'executor':
                $executor = new Executor();
                $json->data->expr = Arr::wrap($json->data->expr);

                foreach ($json->data->expr as $expr) {
                    $result = $executor->execute($expr);
                    $this->alert($expr . ' = ' . $result);
                }
                break;

            /**
             * Operations with intervals
             */
            case 'interval':
                $operationRunner = new OperationRunner($json->data->action);
                $json->data->interval = Arr::wrap($json->data->interval);

                foreach ($json->data->interval as $interval) {
                    $operationRunner->addInterval(new Interval($interval));
                }

                $result = $operationRunner->execute();
                $expr = $operationRunner->expr();

                $this->alert($expr . ' = ' . $result);
                break;

            /**
             * Point Factory
             */
            case 'point':
                $logger = Logger::getInstance()
                    ->addChanel(new Console());

                $factory = new Factory(new GeneratorStub, new DeltaFactory(DeltaStub::class));
                $collection = $factory->make($json->data->count);
                $this->table(['l', 'delta', 'fails', 'g'], $collection);
                break;

            /**
             * Parametric Identification
             */
            case 'parametric':
                $logger = Logger::getInstance()
                    ->addChanel(new Console);

                // Prepare config
                $config = Config::getInstance();
                if ($json->config) {
                    $config->merge($jsonHelper->toArray()['config']);
                }

                if ($json->data) {
                    $config->merge(
                        $jsonHelper->toArray()['data'],
                        $json->type . '.' . $json->method
                    );
                }

                // Execute
                $result = (new Identification)->execute();
                $result ? $this->warn('MCN: ' . $result['mcn'] . ', Result: ' . $result['point']) : $this->error('Not found');
                break;

            default:
                $this->error('Data is not specified');
        }

        $this->info('Finish');
    }
}
