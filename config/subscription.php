<?php

declare(strict_types=1);

return [
    'plans' => [
        [
            'id' => 'lite',
            'label' => 'Lite',
            'prices' => [
                [
                    'id' => env('PADDLE_PRICE_LITE_YEARLY'),
                    'label' => 'Forever Free',
                ],
            ],
            'features' => [
                'No Ads to Interrupt Your Game',
                'Play up to 3 Characters',
                'Narrate up to 3 Adventures',
                'Create up to 3 Worlds',
                'Build Lore and Locations',
                'Customize Character Profiles',
                'Follow All Stories with Ease',
                'Have Fun in OOC Forums',
                'Message Anyone Privately',
                'Unlock Plus Features Individually',
            ],
            'button' => 'Join for Free',
        ],
        [
            'id' => 'plus',
            'label' => 'Plus',
            'prices' => [
                [
                    'id' => env('PADDLE_PRICE_PLUS_MONTHLY'),
                    'label' => '9$/month',
                ],
                [
                    'id' => env('PADDLE_PRICE_PLUS_YEARLY'),
                    'label' => '90$/year',
                ],
            ],
            'features' => [
                'All Lite Features Included',
                'Unlimited Worlds',
                'Unlimited Characters',
                'Unlimited Adventures',
                'Download Your Stories as Books',
                'Visualize Faces and Places with AI',
                'Transfer and Share Characters',
                'Supporter Badge in Profile',
                'Vote on Feature Requests',
                'Priority Staff Support',
            ],
            'button' => 'Subscribe to Plus',
        ],
    ],
];
