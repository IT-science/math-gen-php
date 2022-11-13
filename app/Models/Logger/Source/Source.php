<?php
declare(strict_types=1);

namespace App\Models\Logger\Source;

abstract class Source implements SourceInterface
{
    protected string $name;

    public function name(): string
    {
        return $this->name;
    }
}
