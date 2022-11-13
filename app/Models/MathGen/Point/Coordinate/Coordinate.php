<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point\Coordinate;

use Illuminate\Contracts\Support\Arrayable;

class Coordinate implements Arrayable
{
    /**
     * The "i" parameter in math models
     * e.g. i = 1, ..., n
     *
     * @var int
     */
    private $key;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int|float
     */
    private $value;

    /**
     * Coordinate constructor.
     * @param int $key
     * @param string $name
     * @param int|float $value
     */
    public function __construct(int $key, string $name, $value)
    {
        $this->key = $key;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return float|int
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param float|int $value
     * @return Coordinate
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return ['value' => $this->value()];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
