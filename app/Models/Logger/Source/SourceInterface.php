<?php

namespace App\Models\Logger\Source;

interface SourceInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return mixed
     */
    public function prepare();
}
