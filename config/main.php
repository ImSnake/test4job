<?php

//описывает все компоненты приложения, которые требуются ему в единичном виде (т.е. только один объект на работу всего приложения)
use app\services\Db;
use app\services\renderers\TemplateRenderer;
use app\services\Request;
use app\services\Session;

return [
    'rootDir' => "{$_SERVER['DOCUMENT_ROOT']}" . "/../",
    'templateDir' => "{$_SERVER['DOCUMENT_ROOT']}" . "/../" . "views/",
    'defaultController' => 'site',
    'controllerNamespace' => "app\\controllers",
    'components' => [
        'db' => [
            'class' => Db::class,
            'driver' => 'mysql',
            'host' => 'localhost', //
            'login' => 'root', //'u0540910_default', 'root'
            'password' => '', //'te6N!KfJ', ''
            'database' => 'beejee_test', //'u0540910_gb_course_project' , 'beejee_test'
            'charset' => 'utf8'
        ],
        'request' => [
            'class' => Request::class
        ],
        'renderer' => [
            'class' => TemplateRenderer::class
        ],
        'session' => [
            'class' => Session::class
        ]
    ]
];
