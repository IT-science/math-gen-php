<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\Config;

use App\Models\Config\Config as BaseConfig;

abstract class Config
{
    /**
     * @var BaseConfig
     */
    protected $config;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->config = BaseConfig::getInstance()
            ->node('parametric');
    }

    /**
     * @return mixed
     */
    abstract public function get();
}
