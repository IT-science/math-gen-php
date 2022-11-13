<?php

declare(strict_types=1);

namespace App\Models\Math\Interval\Operation;

use App\Models\Math\Interval\Interval;
use App\Models\Math\Interval\Exception\DifferentResultsException;

class Division extends Operation
{
    /**
     * @return Interval
     * @throws DifferentResultsException
     */
    public function execute(): Interval
    {
        $intervalA = $this->intervals[0];
        $intervalB = $this->intervals[1];

        // $result1 = $this->version1($intervalA, $intervalB);
        $result2 = $this->version2($intervalA, $intervalB);

        return $result2;

        /* $isEqual = (new IsEqual)
            ->addInterval($result1)
            ->addInterval($result2)
            ->execute();

        if (! $isEqual) {
            $message = 'Different results: ' . join(' | ', [$result1, $result2]);
            throw new DifferentResultsException($message);
        }

        return $result1; */
    }

    /**
     * @param Interval $intervalA
     * @param Interval $intervalB
     * @return Interval
     */
    private function version1(Interval $intervalA, Interval $intervalB): Interval
    {
        $intervalBInverted = new Interval(
            1 / $intervalB->right(),
            1 / $intervalB->left()
        );

        return (new Multiplication)
            ->addInterval($intervalA)
            ->addInterval($intervalBInverted)
            ->execute();
    }

    /**
     * @param Interval $intervalA
     * @param Interval $intervalB
     * @return Interval
     */
    private function version2(Interval $intervalA, Interval $intervalB): Interval
    {
        $numbers = [
            $intervalA->left() / $intervalB->left(),
            $intervalA->left() / $intervalB->right(),
            $intervalA->right() / $intervalB->left(),
            $intervalA->right() / $intervalB->right(),
        ];

        return new Interval(min($numbers), max($numbers));
    }

    /**
     * Looks like this returns only integer boundaries
     * https://neerc.ifmo.ru/wiki/index.php?title=%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%B2%D0%B0%D0%BB%D1%8C%D0%BD%D0%B0%D1%8F_%D0%B0%D1%80%D0%B8%D1%84%D0%BC%D0%B5%D1%82%D0%B8%D0%BA%D0%B0
     *
     * @param Interval $intervalA
     * @param Interval $intervalB
     * @return Interval
     */
    private function version3(Interval $intervalA, Interval $intervalB): Interval
    {
        $numbers1 = [
            floor($intervalA->left() / $intervalB->left()),
            floor($intervalA->left() / $intervalB->right()),
            floor($intervalA->right() / $intervalB->left()),
            floor($intervalA->right() / $intervalB->right()),
        ];

        $numbers2 = [
            ceil($intervalA->left() / $intervalB->left()),
            ceil($intervalA->left() / $intervalB->right()),
            ceil($intervalA->right() / $intervalB->left()),
            ceil($intervalA->right() / $intervalB->right()),
        ];

        return new Interval(min($numbers1), max($numbers2));
    }
}
