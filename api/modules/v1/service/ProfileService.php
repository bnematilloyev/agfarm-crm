<?php

namespace api\modules\v1\service;

use api\modules\admin\models\forms\UploadForm;
use api\modules\admin\models\forms\UploadUserActionPhotoForm;
use common\models\AdminWorkSchedule;
use common\models\constants\GeneralStatus;
use common\models\constants\WeekDay;
use common\models\User;
use common\helpers\Utilities;
use common\models\UserActivityDuration;
use common\models\UserWorkplaces;
use common\models\UserWorkTime;
use DateTime;
use Yii;
use yii\db\Exception;

class ProfileService
{
    public function getCurrentUserAsArray(): array
    {
        $currentUser = Yii::$app->user->identity;
        return [
            "id" => $currentUser->id,
            "full_name" => $currentUser->full_name,
            "phone_number" => $currentUser->phone,
            "company" => [
                "id" => $currentUser->company_id,
                "name" => $currentUser->company->name,
                "logo" => Yii::getAlias('@assets_url') . '/company' . $currentUser->company->image
            ],
            "office" => $currentUser->company->address,
        ];
    }

    /**
     * @param $post
     * @return string|void
     * @throws Exception
     */
    public function getAboutUsContent()
    {
        $filePath = \Yii::getAlias('@api') . '/content/about.php';
        return file_get_contents($filePath);
    }
}