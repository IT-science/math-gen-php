<?php
declare(strict_types=1);

namespace App\Models\Logger\Channel;

abstract class Channel implements ChannelInterface
{
    protected string $name;

    public function name(): string
    {
        return $this->name;
    }
}
