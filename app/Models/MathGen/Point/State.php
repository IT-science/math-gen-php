<?php

declare(strict_types=1);

namespace App\Models\MathGen\Point;

abstract class State implements StateInterface
{
    /**
     * @var self
     */
    // private static $instance;

    /**
     * @var int
     */
    private $pointKey;

    /**
     * @var int
     */
    private $coordinateKey;

    /**
     * State constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return static
     */
    /*public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }*/

    /**
     * @return int
     */
    public function pointKey(): int
    {
        return $this->pointKey;
    }

    /**
     * @param int $pointKey
     * @return State
     */
    public function setPointKey(int $pointKey): StateInterface
    {
        $this->pointKey = $pointKey;
        return $this;
    }

    /**
     * @return int
     */
    public function coordinateKey(): int
    {
        return $this->coordinateKey;
    }

    /**
     * @param int $coordinateKey
     * @return State
     */
    public function setCoordinateKey(int $coordinateKey): StateInterface
    {
        $this->coordinateKey = $coordinateKey;
        return $this;
    }

    /**
     * @return string
     */
    abstract public function coordinateName(): string;
}
