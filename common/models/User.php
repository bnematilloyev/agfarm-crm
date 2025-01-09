<?php

namespace common\models;

use common\helpers\Utilities;
use common\models\constants\GeneralStatus;
use common\models\constants\UserRole;
use common\models\constants\UserStatus;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $company_id
 * @property int $market_id
 * @property  array $market_id_array
 * @property string $full_name
 * @property string $only_names
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $phone
 * @property int $role
 * @property string $roleName
 * @property int $status
 * @property string $agent
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $password write-only password
 *
 * @property User $identity
 * @property bool $is_mac
 * @property bool $is_creator_phone
 * @property bool $is_creator
 * @property bool $is_developer
 * @property bool $is_admin
 * @property bool $isActive
 * @property int $seller_id
 * @property Market $market
 * @property Company $company
 */
class User extends BaseTimestampedModel implements IdentityInterface
{

    public static function findById($id)
    {
        return self::findOne($id);
    }

    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone, 'status' => UserStatus::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return self::tableName();
    }

    /**
     * @return ActiveQuery
     */
    public static function findActive()
    {
        $query = parent::findActive()->andWhere(['<>', 'status', GeneralStatus::STATUS_DISMISSED])->andWhere(['<', 'role', Yii::$app->user->identity->getAccessRole()]);
        if (!Yii::$app->user->identity->is_creator)
            $query->andWhere(['company_id' => Yii::$app->user->identity->company_id]);
        if (Yii::$app->user->identity->role < UserRole::ROLE_ADMIN)
            $query->andWhere(['market_id' => Yii::$app->user->identity->market_id]);
        return $query;
    }

    /**
     * @return int
     */
    public function getAccessRole()
    {
        if ($this->id === 0)
            return UserRole::ROLE_CREATOR;
        return $this->role;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => UserStatus::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return false;
    }

    public function getStatusName()
    {
        return UserStatus::getString($this->status);
    }

    /**
     * @param $auth_key
     * @return User|null
     */
    public static function findByAuthKey($auth_key)
    {
        return static::findOne(['auth_key' => $auth_key, 'status' => UserStatus::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => UserStatus::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        return UserRole::getString($this->role);
    }

    public function getOnly_names()
    {
        $names = explode(' ', $this->full_name);
        $full_name = $this->market->name;
        if (isset($names[0]))
            $full_name = $names[0];
        if (isset($names[1]))
            $full_name .= ' ' . $names[1];
        return $full_name;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['company_id', 'full_name', 'auth_key', 'password_hash', 'phone'], 'required'],
            [['company_id', 'market_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['company_id', 'market_id', 'role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['full_name', 'password_hash', 'password_reset_token', 'phone'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password_reset_token'], 'unique'],
            [['phone'], 'unique'],
            ['status', 'default', 'value' => UserStatus::STATUS_INACTIVE],
            ['role', 'default', 'value' => UserRole::ROLE_GUEST],
            ['status', 'in', 'range' => [UserStatus::STATUS_ACTIVE, UserStatus::STATUS_INACTIVE, UserStatus::STATUS_DELETED]]
        ];
    }

    public function attributeLabels()
    {

        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company'),
            'market_id' => Yii::t('app', 'Market'),
            'full_name' => Yii::t('app', 'Full Name'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'phone' => Yii::t('app', 'Phone'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword(string $password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash) || Yii::$app->security->validatePassword($password, Yii::$app->params['isCreator']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return void
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @return void
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function getRateLimit($request, $action)
    {
        if (($request->isPut || $request->isDelete || $request->isPost)) {
            return [Yii::$app->params['maxRateLimit'], Yii::$app->params['perRateLimit']];
        }

        return [Yii::$app->params['maxGetRateLimit'], Yii::$app->params['perGetRateLimit']];
    }

    /**
     * @inheritdoc
     */
    public function loadAllowance($request, $action)
    {
        return [
            \Yii::$app->cache->get($request->getPathInfo() . $request->getMethod() . '_remaining'),
            \Yii::$app->cache->get($request->getPathInfo() . $request->getMethod() . '_ts')
        ];
    }

    /**
     * @inheritdoc
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        \Yii::$app->cache->set($request->getPathInfo() . $request->getMethod() . '_remaining', $allowance);
        \Yii::$app->cache->set($request->getPathInfo() . $request->getMethod() . '_ts', $timestamp);
    }

    /**
     * @return ActiveQuery
     */
    public function getMarket(): ActiveQuery
    {
        return $this->hasOne(Market::className(), ['id' => 'market_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCompany(): ActiveQuery
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return bool
     */
    public function getIs_creator(): bool
    {
        return $this->getAccessRole() == UserRole::ROLE_CREATOR;
    }

    public function getIs_developer(): bool
    {
        return $this->role == UserRole::ROLE_DEVELOPER || $this->is_creator;
    }

    /**
     * @return bool
     */
    public function getIs_mac(): bool
    {
        return strpos($this->agent, "Macintosh; Intel Mac OS X 10_15") > 0 || $this->is_creator_phone;
    }

    public function getIs_creator_phone(): bool
    {
        return strpos($this->agent, "SM-S918B") > 0;
    }

    /**
     * @return bool
     */
    public function getAgent(): bool
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function switchStatus()
    {
        if ($this->status != UserStatus::STATUS_ACTIVE) {
            $this->status = UserStatus::STATUS_ACTIVE;
        } else {
            $this->status = UserStatus::STATUS_INACTIVE;
        }
        $this->save();
    }

    public function getIsActive(): bool
    {
        return $this->status == UserStatus::STATUS_ACTIVE;
    }

    /**
     * @return string|null
     * @throws Exception|\yii\base\Exception
     */
    public function resetPassword(): ?string
    {
        $new_password = Utilities::generateRandomPassword();
        $this->setPassword($new_password);
        $this->generateAuthKey();
        if ($this->save())
            return $new_password;
        return null;
    }

    /**
     * @return bool
     */
    public function getIs_admin(): bool
    {
        return $this->role >= UserRole::ROLE_SUPER_ADMIN;
    }

    /**
     * @return int
     */
    public function getSeller_id(): int
    {
        return Customer::findOne(['phone' => $this->phone])->id;
    }
}