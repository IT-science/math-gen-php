<?php

declare(strict_types=1);

namespace App\Models\Config;

use App\Models\Config\Exception\KeyDoesNotExistException;
use Illuminate\Support\Arr;

class Config implements ConfigInterface
{
    /**
     * Config base key
     */
    const BASE_KEY = 'math_gen';

    /**
     * @var self
     */
    private static $instance;

    /**
     * @var array
     */
    private $data;

    /**
     * Config constructor.
     */
    private function __construct()
    {
        $this->data = config(self::BASE_KEY, []);
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return Arr::has($this->data, $this->prepareKey($key));
    }

    /**
     * @inheritDoc
     */
    public function get(string $key = null, $default = null)
    {
        if (null !== $key && ! $this->has($key)) {
            throw new KeyDoesNotExistException($key);
        }

        return Arr::get($this->data, $this->prepareKey($key), $default);
    }

    /**
     * @inheritDoc
     */
    public function orig(string $key = null, $default = null)
    {
        $keyPrepared = $this->prepareKey(self::BASE_KEY . '.' . $key);

        if (null !== $key && ! config()->has($keyPrepared)) {
            throw new KeyDoesNotExistException($key);
        }

        return config($keyPrepared, $default);
    }

    /**
     * @inheritDoc
     */
    public function merge(array $data, string $key = null): self
    {
        if (null !== $key) {
            $key = $this->prepareKey($key);

            if (! $key || ! $this->has($key)) {
                throw new KeyDoesNotExistException($key);
            }

            $data = array_replace_recursive($this->get($key), $data);
            Arr::set($this->data, $key, $data);
        } else {
            $this->data = array_replace_recursive($this->data, $data);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function node(string $key): NodeInterface
    {
        if (! $this->has($key)) {
            throw new KeyDoesNotExistException($key);
        }

        return new Node($key);
    }

    /**
     * @param string|null $key
     * @return string|null
     */
    private function prepareKey(?string $key): ?string
    {
        if (null === $key) {
            return null;
        }

        $key = trim(trim($key), '.');
        return $key ?: null;
    }
}
