<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => '/',
    'defaultRoute' => 'default',
    'modules' => [
        'cabinet' => [
            'class' => 'app\modules\cabinet\Module',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/courses/<type:[a-zA-Z0-9-]+>' => '/default/courses',
                '/course/<slug:[a-zA-Z0-9-]+>' => '/default/course',
                '/test/<id:\d+>' => '/default/module-test',
                '/test-result/<id:\d+>' => '/default/test-result',
                '/examine/<slug:[a-zA-Z0-9-]+>' => '/default/examine',
                '/course-result/<slug:[a-zA-Z0-9-]+>' => '/default/course-result',
                '/<action_default>' => '/default/<action_default>',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'default/error',
        ],
    ],
    'params' => $params,
];
