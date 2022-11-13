<?php

namespace App\Models\Logger\Channel;

interface ChannelInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @param $data
     * @return ChannelInterface
     */
    public function write($data): self;
}
