<?php

namespace backend\controllers;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class AjaxController extends BaseController
{
    public function actionNameAutocomplete($term)
    {
        $out = [];
        if (!is_null($term) && strlen($term) > 2) {
            $query = new Query();
            $query->select('name_' . Yii::$app->language . ' AS text')
                ->from('product');
            $keys = explode(' ', $term);
            foreach ($keys as $key) {
                $query->andWhere(['or',
                    ['ilike', 'name_ru', $key],
                    ['ilike', 'name_uz', $key],
                    ['ilike', 'name_en', $key]
                ]);
            }

            $query->limit(10);
            $command = $query->createCommand();
            $out = $command->queryAll();
            $out = array_values($out);
            if (count($out) > 0) {
                $out = ArrayHelper::getColumn(array_values($out), 'text');
            }
        }

        return $out;
    }

}