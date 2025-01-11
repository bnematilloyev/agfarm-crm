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
            'dsn' => 'pgsql:host=127.0.0.1;dbname=drugs',
            'username' => 'postgres',
            'password' => 'BdWKjg5QB55z',
            'charset' => 'utf8',
        ],
    ],
];
