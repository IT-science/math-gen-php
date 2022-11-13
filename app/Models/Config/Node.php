<?php

declare(strict_types=1);

namespace App\Models\Config;

class Node implements NodeInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $key;

    /**
     * Node constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->config = Config::getInstance();
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return $this->config->has($this->prepareKey($key));
    }

    /**
     * @inheritDoc
     */
    public function get(string $key = null, $default = null)
    {
        return $this->config->get($this->prepareKey($key), $default);
    }

    /**
     * @inheritDoc
     */
    public function orig(string $key = null, $default = null)
    {
        return $this->config->orig($this->prepareKey($key), $default);
    }

    /**
     * @inheritDoc
     */
    public function merge(array $data, string $key = null): self
    {
        $this->config->merge($data, $this->prepareKey($key));
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function node(string $key): NodeInterface
    {
        return $this->config->node($this->prepareKey($key));
    }

    /**
     * @param string|null $key
     * @return string
     */
    private function prepareKey(?string $key): string
    {
        return $this->key . ($key ? '.' . $key : null);
    }
}
