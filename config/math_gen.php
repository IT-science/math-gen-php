<?php

return [
    /**
     * Parametric Identification
     */
    'parametric' => [

        'MCN_MAX' => 10000000,

        /**
         * Bee Colony Method
         */
        'bee_colony' => [

            'MCN' => 1000,

            /**
             * Local minima limit
             */
            'fails_limit' => 20,

            /**
             * Math param "S"
             */
            'count_bees' => 10,

            /**
             * Limits for point coordinates: [min, max]
             */
            'limits' => [
                'all' => [-1, 1],
            ],

            /**
             * Expressions
             */
            'point_seeker_initial' => 'max + randf(0, 1) * (min - max)',

            'point_seeker' => [
                'distance = randf(-1, 1)',
                'direction1 = currentCoord + distance * (currentCoord - otherCoord)',
                'direction2 = currentCoord + (distance * -1) * (currentCoord - otherCoord)',
                'if (direction1 > max || direction1 < min, direction2, direction1)',
            ],
        ],
    ]
];
