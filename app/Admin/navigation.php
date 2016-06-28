<?php

use SleepingOwl\Admin\Navigation\Page;

return [
    [
        'title' => 'Permissions',
        'icon' => 'fa fa-group',
        'accessLogic' => function (Page $page) {
            return auth()->user()->isSuperAdmin();
        },
        'pages' => [
            (new Page(\App\User::class))
                ->setIcon('fa fa-user')
                ->setPriority(0),
            (new Page(\App\Role::class))
                ->setIcon('fa fa-group')
                ->setPriority(100)
            ]
    ]
];