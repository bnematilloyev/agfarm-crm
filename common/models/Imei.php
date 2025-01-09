<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "imei".
 *
 * @property int $id
 * @property int $seller_id
 * @property int $buyer_id
 * @property int|null $company_id
 * @property int|null $market_id
 * @property int|null $product_id
 * @property string|null $imei1
 * @property string|null $imei2
 * @property string|null $description
 * @property int|null $expires_in
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Customer $seller
 * @property Customer $buyer
 * @property Product $product
 */
class Imei extends BaseTimestampedModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imei';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'market_id', 'product_id', 'imei1', 'imei2', 'description', 'expires_in', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['seller_id', 'buyer_id'], 'required'],
            [['seller_id', 'buyer_id', 'company_id', 'market_id', 'product_id', 'expires_in', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['seller_id', 'buyer_id', 'company_id', 'market_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['expires_in'], 'safe'],
            [['imei1', 'imei2'], 'string', 'min' => 15],
            [['imei1', 'imei2'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => Yii::t('app', "IMEI qiymati 0-9 gacha bo'lgan raqamlardan iborat bo'lishi kerak")],
            [['imei1', 'imei2'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'seller_id' => Yii::t('app', 'Seller ID'),
            'buyer_id' => Yii::t('app', 'Buyer ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'market_id' => Yii::t('app', 'Market ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'imei1' => Yii::t('app', 'Imei1'),
            'imei2' => Yii::t('app', 'Imei2'),
            'description' => Yii::t('app', 'Description'),
            'expires_in' => Yii::t('app', 'Expires In'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSeller(): ActiveQuery
    {
        return $this->hasOne(Customer::className(), ['id' => 'seller_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getBuyer(): ActiveQuery
    {
        return $this->hasOne(Customer::className(), ['id' => 'buyer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function setBasic()
    {
        $user = Yii::$app->user->identity;
        $this->expires_in = date('d.m.Y');
        $this->seller_id = $user->seller_id;
        $this->company_id = $user->company_id;
        $this->market_id = $user->market_id;
    }
}
