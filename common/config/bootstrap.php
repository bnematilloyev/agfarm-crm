<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('rest', dirname(dirname(__DIR__)) . '/rest');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@vendor', dirname(dirname(__DIR__)));
Yii::setAlias('@assets', str_replace("\\", "/", dirname(dirname(__DIR__)) . '/assets'));
//if(strpos($_SERVER['HTTP_HOST'], 'local') !== false)
Yii::setAlias('assets_url', 'http://assets.drugs.local/');
//else
//    Yii::setAlias('assets_url', 'http://assets.crm-drug.local/');
Yii::setAlias('@original_files', str_replace("\\", "/", dirname(dirname(__DIR__)) . '/original'));
