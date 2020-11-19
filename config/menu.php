<?php
return [
    'view_user|create_user' => [
        [
            'label' => 'Users',
            'route' => 'user.list',
            'sub' => [
                'create_user' => [
                    [
                        'label' => 'Add user',
                        'route' => 'user.add'
                    ]
                ],
                'view_user' => [
                    [
                        'label' => 'View users',
                        'route' => 'user.list'
                    ]
                ]
            ]
        ]
    ],
    'view_all_task|view_own_task|create_task' => [
        [
            'label' => 'Tasks',
            'route' => 'task.list',
            'sub' => [
                'view_all_task|view_own_task' => [
                    [
                        'label' => 'View tasks',
                        'route' => 'task.list'
                    ]
                ],
                'create_task' => [
                    [
                        'label' => 'Create task',
                        'route' => 'task.add'
                    ]
                ]
            ]
        ]
    ],
    'view_role|add_role' => [
        [
            'label' => 'Roles',
            'route' => 'role.list',
            'sub' => [
                'create_role' => [
                    [
                        'label' => 'Create role',
                        'route' => 'role.add'
                    ]
                ],
                'view_role' => [
                    [
                        'label' => 'View roles',
                        'route' => 'role.list'
                    ]
                ]
            ]
        ]
    ]
];