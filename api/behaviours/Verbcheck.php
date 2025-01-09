<?php

namespace api\behaviours;

use Yii;
use yii\base\ActionEvent;
use yii\filters\VerbFilter;

/**
 * Created by PhpStorm.
 * User: sirink
 * Date: 29/04/15
 * Time: 2:15 AM
 */
class Verbcheck extends VerbFilter
{


    /**
     * @param ActionEvent $event
     * @return boolean
     * @throws \yii\base\ExitException
     */
    public function beforeAction($event)
    {
        $action = $event->action->id;


        if (isset($this->actions[$action])) {
            $verbs = $this->actions[$action];
        } elseif (isset($this->actions['*'])) {
            $verbs = $this->actions['*'];
        } else {
            return $event->isValid;
        }

        $verb = Yii::$app->getRequest()->getMethod();
        $allowed = array_map('strtoupper', $verbs);
        if (!in_array($verb, $allowed)) {
            $event->isValid = false;
            // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7
            Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', $allowed));
            Yii::$app->getResponse()->data = [
                'status' => 0,
                'message' => 'Method Not Allowed. This url can only handle the following request methods: ' . implode(', ', $allowed) . '.'
            ];
            Yii::$app->end();
            // throw new MethodNotAllowedHttpException('Method Not Allowed. This url can only handle the following request methods: ' . implode(', ', $allowed) . '.');
        }

        return $event->isValid;
    }

}
