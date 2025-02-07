<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_category".
 *
 * @property int $id
 * @property string|null $name_uz
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property string|null $image
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string|null $description_en
 * @property int|null $parent_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Product[] $products
 */
class ProductCategory extends BaseTimestampedModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru', 'name_en', 'description_uz', 'description_ru', 'description_en', 'parent_id', 'created_at', 'updated_at', 'image'], 'default', 'value' => null],
            [['description_uz', 'description_ru', 'description_en'], 'string'],
            [['parent_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['parent_id', 'created_at', 'updated_at'], 'integer'],
            [['name_uz', 'name_ru', 'name_en', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_uz' => Yii::t('app', 'Name Uz'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
            'description_uz' => Yii::t('app', 'Description Uz'),
            'description_ru' => Yii::t('app', 'Description Ru'),
            'description_en' => Yii::t('app', 'Description En'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'image' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

}
