<?php
return [
    'users' => [
        [
            'name' => 'Nasrul Hazim',
            'email' => 'nasrulhazim@gmail.com',
            'password' => 'password'
        ],
        [
            'name' => 'Khamsany Misran',
            'email' => 'khamsany@gmail.com',
            'password' => 'password'
        ]
    ],
    'clients' => [
        [
            'name' => 'MBB Sdn Bhd',
            'repositories' => [
                'MagnificientDashboardX'
            ],
            'users' => [
                [
                    'email' => 'nasrulhazim@gmail.com',
                    'role' => 'manager',
                ],
                [
                    'email' => 'khamsany@gmail.com',
                    'role' => 'client'
                ]
            ]
        ],
        [
            'name' => 'Super Nova Ltd',
            'repositories' => [
                'HomeNetApiDoc'
            ],
            'users' => [
                [
                    'email' => 'nasrulhazim@gmail.com',
                    'role' => 'client',
                ],
            ]
        ]
    ]
];
