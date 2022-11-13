<?php

declare(strict_types=1);

namespace App\Models\Helper;

class Json
{
    /**
     * @var string
     */
    private $json;

    /**
     * @var bool
     */
    private $associative = false;

    /**
     * @param $filePath
     * @return bool
     */
    public function readFile($filePath)
    {
        if (! file_exists($filePath)) {
            return false;
        }

        $this->json = file_get_contents($filePath);

        return true;
    }

    /**
     * @param string $json
     * @param bool $associative
     * @return mixed
     */
    public function decode(string $json = null)
    {
        if (null === $json) {
            $json = $this->json;
        }

        return json_decode($json, $this->associative);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return json_decode($this->json, true);
    }
}
