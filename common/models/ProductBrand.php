<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_brand".
 *
 * @property int $id
 * @property string|null $name_uz
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property string|null $slug
 * @property string|null $image
 * @property bool|null $home_page
 * @property string|null $meta_json_uz
 * @property string|null $meta_json_ru
 * @property string|null $meta_json_en
 * @property int $status
 * @property string|null $official_link
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Product[] $products
 */
class ProductBrand extends BaseTimestampedModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru', 'name_en', 'slug', 'image', 'home_page', 'meta_json_uz', 'meta_json_ru', 'meta_json_en', 'official_link', 'description_uz', 'description_ru', 'description_en'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 10],
            [['home_page'], 'boolean'],
            [['meta_json_uz', 'meta_json_ru', 'meta_json_en'], 'safe'],
            [['status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name_uz', 'name_ru', 'name_en', 'slug', 'image', 'official_link'], 'string', 'max' => 255],
            [['description_uz', 'description_ru', 'description_en'], 'string', 'max' => 6000],
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
            'slug' => Yii::t('app', 'Slug'),
            'image' => Yii::t('app', 'Image'),
            'home_page' => Yii::t('app', 'Home Page'),
            'meta_json_uz' => Yii::t('app', 'Meta Json Uz'),
            'meta_json_ru' => Yii::t('app', 'Meta Json Ru'),
            'meta_json_en' => Yii::t('app', 'Meta Json En'),
            'status' => Yii::t('app', 'Status'),
            'official_link' => Yii::t('app', 'Official Link'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['brand_id' => 'id']);
    }

}
