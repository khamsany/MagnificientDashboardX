<?php
return [
    'users' => [
        [
            'name' => 'Mr. Manager',
            'email' => 'khamsany@yahoo.com',
            'password' => 'password'
        ],
        [
            'name' => 'Mr. Client',
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
                    'email' => 'khamsany@yahoo.com',
                    'role' => 'manager',
                ],
                [
                    'email' => 'khamsany@gmail.com',
                    'role' => 'client'
                ]
            ]
        ]
    ]
];
