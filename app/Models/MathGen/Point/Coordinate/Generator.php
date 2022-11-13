<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point\Coordinate;

abstract class Generator implements GeneratorInterface
{
    /**
     * @var int
     */
    private $pointKey;

    /**
     * @return int
     */
    public function pointKey(): int
    {
        return $this->pointKey;
    }

    /**
     * @inheritDoc
     */
    public function setPointKey(int $pointKey): GeneratorInterface
    {
        $this->pointKey = $pointKey;
        return $this;
    }
}
