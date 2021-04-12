<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'name' => 'Учебный центр ЗНАНИЯ',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU', // 'ru-RU'
    'components' => [
        'db' => require(dirname(__DIR__) . "/config/db.php"),
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'i18n' => [
            'translations' => [
                // app* - это шаблон, который определяет, какие категории
                // обрабатываются источником. В нашем случае, мы обрабатываем все, что начинается с app
                'app*' => [
                    'class' => yii\i18n\PhpMessageSource::className(),
                    //
                    'basePath' => '@app/messages',
                    // исходный язык
                    'sourceLanguage' => 'ru-RU',
                    // определяет, какой файл будет подключаться для определённой категории
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ]
                ],
            ]
        ],

    ],
];
