<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 25/12/2020
 * Time: 19:06
 */


namespace console\controllers;

use api\modules\nasiya\service\ProfileService;
use common\helpers\CustomerDegreeHelper;
use common\helpers\LawyerUtils;
use common\helpers\TelegramHelper;
use common\models\constants\DeviceType;
use common\models\constants\GeneralStatus;
use common\models\constants\UserRole;
use common\models\constants\UserStatus;
use pay\models\Customer;
use common\models\CustomerCard;
use common\models\User;
use common\models\UserActivity;
use common\services\ScoringService;
use yii\console\Controller;

class UserController extends Controller
{
    private $telegramService;

    public function __construct($id, $module, $config = [])
    {
        $this->telegramService = new TelegramHelper(false);
        $this->telegramService->setChatIdBySlug();
        parent::__construct($id, $module, $config);
    }

    /**
     * @run php yii user/reset-all-password
     * @return void
     */
    public function actionResetAllPassword($ignore = false)
    {
        $this->telegramService->setChatIdBySlug('security-info');
        foreach (User::find()->orderBy('id')->each() as $admin) {
            /** @var User $admin */
            $new_password = $admin->resetPassword();
            $role = UserRole::getString($admin->role);
            $txt = "Tizim: $admin->roleSystem\nFIO: $admin->full_name\nRole : $role\nHolati: $admin->statusName\nLogin: `$admin->username`\nParol: `$new_password`";
            if ($admin->save() && !$ignore && $admin->isActive) {
                $this->telegramService->sendMessage($txt, 'markdown');
            }
        }
    }

    public function actionResetAllPassive()
    {
        $users = User::find()->where(['status' => UserStatus::STATUS_INACTIVE]);
        foreach ($users->each() as $admin) {
            /** @var User $admin */
            $new_password = $admin->resetPassword();
            $this->telegramService->sendMessage("$admin->full_name\n$admin->roleName\nstatus: $admin->status\nlogin: $admin->username\npassword: $new_password");
        }
    }

    public function actionDeleteDoubleCard()
    {
        $customers = Customer::find()->orderBy(['id' => SORT_ASC]);
        $disconnectedCard = CustomerCard::find()->andWhere(['card_token' => null]);
        echo (clone $disconnectedCard)->count('id') . "\n";

        $cnt = 0;
        foreach ($customers->each() as $customer) {
            /** @var Customer $customer */
            $cards = CustomerCard::find()->andWhere(['customer_id' => $customer->id]);
            if ((clone $cards)->count('id') <= 1) continue;
            $disconnectCard = (clone $cards)->andWhere(['card_token' => null]);
            $connectCard = (clone $cards)->andWhere(['not', ['card_token' => null]]);
            foreach ($disconnectCard->each() as $card) {
                /** @var CustomerCard $card */
                if ($card->card_token != null) continue;
                $predict = substr($card->holder, 0, 6) . '******' . substr($card->holder, -4);
                if ((clone $connectCard)->andWhere(['and', ['holder' => $predict], ['cv' => $card->cv]])->count('id') >= 1) {
                    echo "customer_id = " . $customer->id . " card_id=" . $card->id . " holder=" . $card->holder . "\n";
                    $cnt++;
                }
            }

        }
        echo "Total count = " . $cnt;

    }

    public function actionUpdateOne($id)
    {
        $user = User::findOne($id);
        $user->updateAttributes(['role' => UserRole::ROLE_LEGAL_LAWYER]);
    }

    /**
     * @run php yii user/reset-employees-by-user-id
     * @return void
     */
    public function actionResetEmployeesByUserId($user_id)
    {
        $admin = User::findOne($user_id);
        $admins = User::find()->where(['and', ['in', 'market_id', $admin->getOwner_Market_list()], ['status' => GeneralStatus::STATUS_ACTIVE]]);
        foreach ($admins->each() as $admin) {
            /** @var User $admin */
            $new_password = $admin->resetPassword();
            $this->telegramService->setChatIdBySlug('asaxiy_menejer');
            $text = "$admin->full_name\n$admin->roleName\nstatus: $admin->status\nlogin: $admin->username\npassword: $new_password";
            $this->telegramService->sendMessage($text);
            $this->telegramService->setChatIdBySlug();
            $this->telegramService->sendMessage($text);
        }
    }

    /**
     * @run php yii user/reset-employees-by-market-id
     * @return void
     */
    public function actionResetEmployeesByMarketId($market_id)
    {
        $admins = User::find()->where(['and', ['in', 'market_id', [$market_id]], ['status' => GeneralStatus::STATUS_ACTIVE]]);
        foreach ($admins->each() as $admin) {
            /** @var User $admin */
            $new_password = $admin->resetPassword();
            $this->telegramService->setChatIdBySlug('asaxiy_menejer');
            $text = "$admin->full_name\n$admin->roleName\nstatus: $admin->status\nlogin: $admin->username\npassword: $new_password";
            $this->telegramService->sendMessage($text);
            $this->telegramService->setChatIdBySlug();
            $this->telegramService->sendMessage($text);
        }
    }

    /**
     * @run php yii user/update-user-activity
     * @return void
     */
    public function actionUpdateUserActivity()
    {
        $user_activities = UserActivity::find();
        foreach ($user_activities->each() as $user_activity) {
            /** @var UserActivity $user_activity */
            $user_activity->device_type = DeviceType::detectMobile($user_activity->device_name)
                ? DeviceType::STATUS_MOBILE
                : DeviceType::STATUS_DESKTOP;
            $user_activity->save();
        }
    }
}
