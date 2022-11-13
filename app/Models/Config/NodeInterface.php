<?php

namespace App\Models\Config;

interface NodeInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key = null, $default = null);

    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return mixed
     */
    public function orig(string $key = null, $default = null);

    /**
     * @param array $data
     * @param string|null $key
     * @return $this
     */
    public function merge(array $data, string $key = null);

    /**
     * @param string $key
     * @return $this
     */
    public function node(string $key): self;
}
