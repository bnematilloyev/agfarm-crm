<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_option".
 *
 * @property int $id
 * @property int $option_type
 * @property int $option_name
 * @property string $value
 * @property int $product_id
 * @property int|null $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProductOptionName $optionName
 * @property ProductOptionType $optionType
 * @property Product $product
 */
class ProductOption extends BaseTimestampedModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 10],
            [['option_type', 'option_name', 'value', 'product_id'], 'required'],
            [['option_type', 'option_name', 'product_id', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['option_type', 'option_name', 'product_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'option_type' => Yii::t('app', 'Option Type'),
            'option_name' => Yii::t('app', 'Option Name'),
            'value' => Yii::t('app', 'Value'),
            'product_id' => Yii::t('app', 'Product ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[OptionName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOptionName()
    {
        return $this->hasOne(ProductOptionName::class, ['id' => 'option_name']);
    }

    /**
     * Gets query for [[OptionType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOptionType()
    {
        return $this->hasOne(ProductOptionType::class, ['id' => 'option_type']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

}
