<?php
return [
    'components' => [
        'db_glonass' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=glonass',
            'username' => 'root',
            'password' => '1111',
            'charset' => 'utf8',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=glonass',
            'username' => 'root',
            'password' => '1111',
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