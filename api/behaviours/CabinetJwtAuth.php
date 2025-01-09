<?php

namespace api\behaviours;

use common\models\User;
use yii\web\IdentityInterface;

class CabinetJwtAuth extends ApiJwtAuth
{
    public $actions = [];

    protected function getIdentity($id): ?IdentityInterface
    {
        $client = User::findIdentity($id);
        if (in_array(\Yii::$app->controller->action->id, $this->actions)) {
            return $client;
        }
        if (!isset($client)) {
            return null;
        }
        return $client;
    }
}
