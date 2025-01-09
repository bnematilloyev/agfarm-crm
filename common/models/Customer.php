<?php

namespace common\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $full_name
 * @property string|null $phone
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Customer extends BaseTimestampedModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['full_name'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['full_name', 'phone'], 'string', 'max' => 255],
            [['phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'phone' => Yii::t('app', 'Phone'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public static function createOrUpdateYourSelf(User $user): bool
    {
        $is_exist = self::findOne(['phone' => $user->phone]);
        if (!$is_exist) {
            $model = new self();
            $model->full_name = $user->full_name;
            $model->phone = $user->phone;
            return $model->save();
        } else
            return true;
    }

}
