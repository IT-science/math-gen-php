<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Config;

use App\Models\MathGen\Parametric\BeeColony\Config\Exception\MissedCoordinatesException;
use App\Models\MathGen\Parametric\Config\Config;

class Coordinates extends Config
{
    /**
     * @return string[]
     * @throws MissedCoordinatesException
     */
    public function get(): array
    {
        $coordinates = $this->config->get('bee_colony.coordinates');

        if (empty($coordinates) || ! is_array($coordinates)) {
            throw new MissedCoordinatesException;
        }

        return $coordinates;
    }
}
