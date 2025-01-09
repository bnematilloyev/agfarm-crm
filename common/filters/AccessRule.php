<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 */

namespace common\filters;

use common\models\constants\UserRole;
use common\models\User;

class AccessRule extends \yii\filters\AccessRule
{

    /**
     * @param User $user
     * @return bool
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '*') {
                return true;
            } elseif (!$user->getIsGuest() && ($role == $user->identity->role && $role >= UserRole::ROLE_ADMIN)) {
                return true;
            }
        }

        return false;
    }
}