<?php


namespace merchant\models\forms;

use common\models\Company;
use common\models\constants\GeneralStatus;
use common\models\constants\UserRole;
use common\models\Investor;
use common\models\Market;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $company_id
 * @property int $market_id
 * @property string $username
 * @property string $full_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $phone
 * @property int $role
 * @property int $status
 * @property string $image
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $password write-only password
 * @property string $confirm_password
 * @property bool $change_password
 *
 * @property User $identity
 * @property Market $market
 * @property Company $company
 */
class UserRegisterForm extends Model
{
    public $id;
    public $company_id;
    public $market_id;
    public $username;
    public $full_name;
    public $phone;
    public $role;
    public $status;
    public $image;
    public $password;
    public $confirm_password;
    public $change_password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'full_name', 'password', 'confirm_password', 'role', 'market_id', 'phone', 'company_id'], 'required'],
            [['status', 'change_password', 'role', 'market_id', 'company_id'], 'integer'],
            ['status', 'default', 'value' => GeneralStatus::STATUS_INACTIVE],
            ['role', 'default', 'value' => UserRole::ROLE_SALER],
            ['status', 'in', 'range' => [GeneralStatus::STATUS_ACTIVE, GeneralStatus::STATUS_DELETED, GeneralStatus::STATUS_INACTIVE]],
            [['username', 'full_name', 'phone', 'image'], 'string', 'max' => 255],
            [['phone'], 'match', 'pattern' => '/((\+998)|0)[-]?[0-9]{9}/'],
            [['username'], 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => '5 tadan kam bo\'lmagan, faqat lotin kichik harflari bo\'lishi kerak'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Parollar bir-biriga mos kelmaydi'],
            ['username', 'unique', 'targetClass' => User::className(),
                'message' => 'Ushbu login oldindan mavjud', 'when' => function ($model) {
                return !$model->id;
            }],
            [['username', 'full_name', 'password'], 'string', 'min' => 5],
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

        if (Yii::$app->user->identity->role < UserRole::ROLE_ADMIN)
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
            'username' => Yii::t('app', 'Login'),
            'full_name' => Yii::t('app', 'Full Name'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'phone' => Yii::t('app', 'Phone'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'image' => Yii::t('app', 'Image'),
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
        $form->username = $user->username;
        $form->phone = $user->phone;
        $form->image = $user->image;
        $form->role = $user->role;
        $form->full_name = $user->full_name;
        $form->status = $user->status;
        $form->password = $user->password_hash;
        $form->confirm_password = $user->password_hash;
        return $form;
    }

    /**
     * @return User
     */
    public function register()
    {
        $user = new User();
        $user->company_id = $this->company_id;
        if (Yii::$app->user->identity->role < UserRole::ROLE_SUPER_ADMIN)
            $user->company_id = Yii::$app->user->identity->company_id;
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->role = $this->role;
        $user->status = $this->status;
        $user->market_id = $this->market_id;
        if (Yii::$app->user->identity->role < UserRole::ROLE_ADMIN)
            $user->market_id = Yii::$app->user->identity->market_id;
        $user->image = '/no-photo.png';
        $user->full_name = $this->full_name;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $user->created_at = time();
        $user->updated_at = time();
        if (!$user->save()) {
            ob_start();
            var_dump($user->errors);
            $result = ob_get_clean();
            throw new \DomainException("Foydalanuvchi saqlashda xatolik: " . $result);
        }
        $this->id = $user->id;
        if ($user->role == UserRole::ROLE_INVESTOR)
            $this->makeInvestor();
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function update(User $user)
    {
        $user->company_id = $this->company_id;
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->role = $this->role;
        $user->market_id = $this->market_id;
        $user->full_name = $this->full_name;
        $user->image = $this->image;
        $user->status = $this->status;
        if ($this->change_password != 0)
            $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $user->updated_at = time();
        if (!$user->save()) {
            ob_start();
            var_dump($user->errors);
            $result = ob_get_clean();
            throw new \DomainException("Foydalanuvchi saqlashda xatolik: " . $result);
        }
        if ($user->role == UserRole::ROLE_INVESTOR)
            $this->makeInvestor();
        return $user;
    }

    public function makeInvestor()
    {
        $investor = Investor::findOne(['user_id' => $this->id]);
        if (!$investor) {
            $investor = new Investor();
            $investor->company_id = $this->company_id;
            $investor->setInitial();
            $investor->balance_uzs = 0;
            $investor->balance_usd = 0;
            $investor->percent = 0;
            $investor->profit_percent = 40;
            $investor->user_id = $this->id;
        }
        $investor->status = $this->status;
        if ($investor->save())
            return true;
        ob_start();
        var_dump($investor->errors);
        $result = ob_get_clean();
        throw new \DomainException("Investor saqlashda xatolik: " . $result);
    }
}