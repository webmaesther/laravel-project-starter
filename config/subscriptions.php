<?php

declare(strict_types=1);

return [
    'plans' => [
        'lite' => [
            'prices' => [
                'yearly' => 'pri_yearly_free_subscription', // 0 price in paddle
            ],
            'features' => [
                'some_feature' => 3, // max
            ],
        ],
        'plus' => [
            'prices' => [
                'monthly' => 'pri_monthly_premium_subscription',
                'yearly' => 'pri_yearly_premium_subscription',
            ],
            'features' => [
                'some_feature' => null, // infinite
            ],
        ],
    ],
];
