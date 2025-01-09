<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 11/7/18
 * Time: 7:49 PM
 *run this on terminal: yii message/extract @common/config/i18n.php
 */
return [
    // this is only for backend now
    'sourcePath' => __DIR__. DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR ,
    'languages' => ['tr', 'uz', 'ru', 'en'],
    'translator' => 'Yii::t',
    'sort' => false,
    'removeUnused' => false,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
//        '/vendor',
    ],
    'format' => 'php',
    'messagePath' => '@common/messages',
    'overwrite' => true,
];

