<?php
return [
    'components' => [
       /*'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=potok-online.ru;dbname=zaytsevipo',
            'username' => 'zaytsevipo',
            'password' => '8TImsvtMR',
            'charset' => 'utf8',
        ],*/
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced_test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];