<?php

declare(strict_types=1);

namespace App\Models\MathGen\Parametric\BeeColony\Config;

use App\Models\MathGen\Parametric\BeeColony\Config\Exception\IncorrectLimitsException;
use App\Models\MathGen\Parametric\BeeColony\Config\Exception\MissedCoordinatesException;
use App\Models\MathGen\Parametric\Config\Config;

class Limits extends Config
{
    /**
     * @return array|\ArrayAccess|mixed
     * @throws MissedCoordinatesException
     * @throws \App\Models\Config\Exception\KeyDoesNotExistException
     */
    public function get()
    {
        $limitsPrepared = [];
        $limits = $this->config->get('bee_colony.limits');
        $coordinates = (new Coordinates)->get();

        if (! empty($limits['all']) && 1 == count($limits)) {
            foreach ($coordinates as $name) {
                $limitsPrepared[$name] = $limits['all'];
            }
        } else {
            unset($limits['all']);
            $limitsPrepared = $limits;
        }

        $this->validate($limitsPrepared);

        return $limitsPrepared;
    }

    /**
     * @param array $limits
     * @return bool
     * @throws IncorrectLimitsException
     * @throws \App\Models\Config\Exception\KeyDoesNotExistException
     */
    private function validate(array $limits): bool
    {
        $coordinates = (new Coordinates)->get();

        if (empty($limits) || count($limits) != count($coordinates)) {
            throw new IncorrectLimitsException;
        }

        foreach ($coordinates as $name) {
            if (empty($limits[$name])
                || 2 != count($limits[$name])
                || ! isset($limits[$name][0])
                || ! isset($limits[$name][1])
                || ! is_numeric($limits[$name][0])
                || ! is_numeric($limits[$name][1])
            ) {
                throw new IncorrectLimitsException;
            }
        }

        return true;
    }
}
