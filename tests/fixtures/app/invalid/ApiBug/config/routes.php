<?php
return [
    'api/test' =>  [
        'route' => '/api/test',
        'paths' => [
            'module' => 'ApiBug',
            'controller' => 'Test'
        ],
        'type' => 'rest',
        'params' => [
            'actions' => [
                '/' =>  [
                    'create' => Vegas\Http\Method::POST,
                ],
                '/{id}' =>  [
                    'delete' => Vegas\Http\Method::DELETE,
                ],
            ]
        ]
    ]
];