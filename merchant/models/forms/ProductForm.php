<?php

namespace merchant\models\forms;

use common\models\constants\GeneralStatus;
use common\models\Product;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\web\UploadedFile;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property $image
 * @property float $price
 * @property string $description
 */
class ProductForm extends Model
{
    public $id;
    public $name;
    public $image;
    public $price;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['name', 'description'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'remote_id' => Yii::t('app', '{Remote} ID', ['Remote' => Yii::$app->user->isGuest ? 'Saytdagi nomi' : Yii::$app->user->identity->company->name]),
            'name' => Yii::t('app', 'Name'),
            'image_link' => Yii::t('app', 'Image Link'),
            'cost' => Yii::t('app', 'Cost'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @throws Exception
     */
    public function save(): bool
    {
        $user = Yii::$app->user->identity;
        $product = new Product();
        $this->image = UploadedFile::getInstance($this, 'image');
        if ($this->image) {
            $path = "/product/" . uniqid("product-image-") . "." . $this->image->extension;
            $fullPath = Yii::getAlias("@assets") . $path;
            $this->image->saveAs($fullPath);
            $product->image_link = "https://assets.abrand.uz" . $path;
        }
        $product->company_id = $user->company_id;
        $product->name = $this->name;
        $product->price = $this->price;
        $product->cost = round($this->price / 1.55, 2);
        $product->description = $this->description;
        $product->status = GeneralStatus::STATUS_INACTIVE;
        if ($product->save()) {
            $this->id = $product->id;
            return true;
        }
        return false;
    }
}
