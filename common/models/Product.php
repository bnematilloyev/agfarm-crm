<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * @property int $brand_id
 * @property string|null $name_uz
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property string|null $description_uz
 * @property string|null $description_ru
 * @property string|null $description_en
 * @property int|null $state
 * @property int $status
 * @property int $sort
 * @property string|null $slug
 * @property string|null $main_image
 * @property string|null $images
 * @property string|null $video
 * @property string|null $meta_json_uz
 * @property string|null $meta_json_ru
 * @property string|null $meta_json_en
 * @property string|null $categories
 * @property string|null $similar
 * @property float|null $actual_price
 * @property float|null $old_price
 * @property float|null $cost
 * @property int $currency_id
 * @property int|null $trust_percent
 * @property int $creator_id
 * @property int|null $updater_admin_id
 * @property int|null $price_changed_at
 * @property string|null $stat
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property ProductBrand $brand
 * @property ProductCategory $category
 * @property Company $company
 * @property User $creator
 * @property ProductCollection[] $productCollections
 * @property User $updaterAdmin
 * @property string $print_id
 */
class Product extends BaseTimestampedModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_ru', 'name_en', 'description_uz', 'description_ru', 'description_en', 'state', 'slug', 'main_image', 'images', 'video', 'meta_json_uz', 'meta_json_ru', 'meta_json_en', 'categories', 'similar', 'actual_price', 'old_price', 'cost', 'trust_percent', 'updater_admin_id', 'price_changed_at', 'stat', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 10],
            [['sort'], 'default', 'value' => 0],
            [['currency_id'], 'default', 'value' => 1],
            [['company_id', 'category_id', 'brand_id', 'creator_id'], 'required'],
            [['company_id', 'category_id', 'brand_id', 'state', 'status', 'sort', 'currency_id', 'trust_percent', 'creator_id', 'updater_admin_id', 'price_changed_at', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['company_id', 'category_id', 'brand_id', 'state', 'status', 'sort', 'currency_id', 'trust_percent', 'creator_id', 'updater_admin_id', 'price_changed_at', 'created_at', 'updated_at'], 'integer'],
            [['description_uz', 'description_ru', 'description_en'], 'string'],
            [['images', 'video', 'categories', 'similar', 'stat'], 'safe'],
            [['actual_price', 'old_price', 'cost'], 'number'],
            [['name_uz', 'name_ru', 'name_en', 'slug', 'main_image', 'meta_json_uz', 'meta_json_ru', 'meta_json_en'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductBrand::class, 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['updater_admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_admin_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Product ID'),
            'print_id' => Yii::t('app', 'Product ID'),
            'company_id' => Yii::t('app', 'Company'),
            'category_id' => Yii::t('app', 'Category'),
            'brand_id' => Yii::t('app', 'Brand'),
            'name_uz' => Yii::t('app', 'Name Uz'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
            'description_uz' => Yii::t('app', 'Description Uz'),
            'description_ru' => Yii::t('app', 'Description Ru'),
            'description_en' => Yii::t('app', 'Description En'),
            'state' => Yii::t('app', 'State'),
            'status' => Yii::t('app', 'Status'),
            'sort' => Yii::t('app', 'Sort'),
            'slug' => Yii::t('app', 'Slug'),
            'main_image' => Yii::t('app', 'Main Image'),
            'images' => Yii::t('app', 'Images'),
            'video' => Yii::t('app', 'Video'),
            'meta_json_uz' => Yii::t('app', 'Meta Json Uz'),
            'meta_json_ru' => Yii::t('app', 'Meta Json Ru'),
            'meta_json_en' => Yii::t('app', 'Meta Json En'),
            'categories' => Yii::t('app', 'Categories'),
            'similar' => Yii::t('app', 'Similar'),
            'actual_price' => Yii::t('app', 'Actual Price'),
            'old_price' => Yii::t('app', 'Old Price'),
            'cost' => Yii::t('app', 'Cost'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'trust_percent' => Yii::t('app', 'Trust Percent'),
            'creator_id' => Yii::t('app', 'Creator ID'),
            'updater_admin_id' => Yii::t('app', 'Updater Admin ID'),
            'price_changed_at' => Yii::t('app', 'Price Changed At'),
            'stat' => Yii::t('app', 'Stat'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(ProductBrand::class, ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    /**
     * Gets query for [[ProductCollections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCollections()
    {
        return $this->hasMany(ProductCollection::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[UpdaterAdmin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdaterAdmin()
    {
        return $this->hasOne(User::class, ['id' => 'updater_admin_id']);
    }

    public function getPrint_Id()
    {
        return 'T' . $this->id;
    }

}
