<?php
/**
 * Local config for developer of environment.
 *
 * @author Evgeniy Tkachenko <et.coder@gmail.com>
 */

return [
    'language' => 'uz',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=127.0.0.1;dbname=test',
            'username' => 'postgres',
            'password' => 'KEM0ndAyT6',
            'charset' => 'utf8',
        ],
    ],
];
