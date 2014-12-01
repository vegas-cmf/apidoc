<?php
return [
    'api/test' =>  [
        'route' => '/api/test',
        'paths' => [
            'module' => 'ApiTest',
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
    ],
    'api/foo' =>  [
        'route' => '/api/foo',
        'paths' => [
            'module' => 'ApiTest',
            'controller' => 'Foo'
        ],
        'type' => 'rest',
        'params' => [
            'actions' => [
                '/' =>  [
                    'create' => Vegas\Http\Method::GET,
                ],
                '/{token}/{type}' =>  [
                    'upload' => Vegas\Http\Method::POST,
                ],
            ]
        ]
    ]
];