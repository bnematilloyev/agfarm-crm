<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project_name".
 *
 * @property int $id
 * @property int $company_id
 * @property integer $type
 * @property string $login_name
 * @property string $index_name
 * @property string $title_name
 * @property string $navbar_name
 * @property string $short_name
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ProjectName extends BaseTimestampedModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project_name';
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return self::tableName();
    }

    public function behaviors()
    {
        return [TimestampBehavior::className()];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login_name', 'index_name', 'title_name', 'navbar_name', 'short_name', 'company_id', 'type'], 'required'],
            [['company_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['login_name', 'index_name', 'title_name', 'navbar_name', 'short_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_ud' => 'Kompaniya',
            'type' => 'Qaysi domenga',
            'login_name' => 'Login sahifadagi nomi',
            'index_name' => 'Index sahifadagi nomi',
            'title_name' => 'Title uchun nom',
            'navbar_name' => 'Navbar-dagi nomi',
            'short_name' => 'Navbardagi qisqa nomi',
            'created_at' => 'Yaratildi',
            'updated_at' => 'O`zgartirildi',
        ];
    }

    public static function getMine($type)
    {
        if (Yii::$app->user->isGuest)
            return self::find()->where(['and', ['company_id' => 1], ['type' => $type]])->one();
        return self::find()->where(['and', ['company_id' => Yii::$app->user->identity->company_id], ['type' => $type]])->one();
    }
}
