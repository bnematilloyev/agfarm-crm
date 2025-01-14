<?php
namespace backend\models\forms;

use backend\models\ImageForm;
use common\models\Company;
use common\models\constants\Currency;
use common\models\constants\ProductState;
use common\models\constants\ProductStatus;
use common\models\constants\PublishableStatus;
use common\models\CurrencyType;
use common\models\Product;
use yii\base\Model;

/**
 *
 * @property ImageForm;
 */
class ProductForm extends Model
{
    public $id;
    public $company_id;
    public $category_id;
    public $brand_id;
    public $name_uz;
    public $name_ru;
    public $name_en;
    public $description_uz;
    public $description_ru;
    public $description_en;
    public $state;
    public $status;
    public $sort;
    public $slug;
    public $main_image;
    public $imageField;
    public $video;
    public $meta_json_uz;
    public $meta_json_ru;
    public $meta_json_en;
    public $categories;
    public $similar;
    public $actual_price;
    public $old_price;
    public $cost;
    public $currency_id;
    public $trust_percent;
    public $creator_id;
    public $updater_admin_id;
    public $price_changed_at;
    public $stat;
    public $created_at;
    public $updated_at;

    private $_product;

    /**
     * ProductForm constructor.
     * @param Product|null $product
     * @param array $config
     */

    public function afterValidate()
    {
        if ($this->hasErrors()) {
            $this->imageForm->imageField = null;
        }

        parent::afterValidate();
    }

    public function __construct(Product $product = null, $config = [])
    {
        $this->company_id = Company::ABDULLO_GRAND_FARM;
        if ($product) {
            $this->_product = $product;
            $this->id = $product->id;
            $this->company_id = $product->company_id;
            $this->brand_id = $product->brand_id;
            $this->category_id = $product->category_id;
            $this->name_uz = $product->name_uz;
            $this->name_ru = $product->name_ru;
            $this->name_en = $product->name_en;
            $this->description_uz = $product->description_uz;
            $this->description_ru = $product->description_ru;
            $this->description_en = $product->description_en;
            $this->state = $product->state;
            $this->status = $product->status;
            $this->sort = $product->sort;
            $this->slug = $product->slug;
            $this->main_image = $product->main_image;
            $this->imageForm = new ImageForm();
            $this->video = $product->video;
            $this->meta_json_uz = $product->meta_json_uz;
            $this->meta_json_ru = $product->meta_json_ru;
            $this->meta_json_en = $product->meta_json_en;
            $this->categories = is_array($product->categories) ? $product->categories : [];
            $this->similar = $product->similar;
            $this->actual_price = $product->actual_price;
            $this->old_price = $product->old_price;
            $this->cost = $product->cost;
            $this->currency_id = $product->currency_id;
            $this->trust_percent = $product->trust_percent;
            $this->creator_id = $product->creator_id;
            $this->updater_admin_id = $product->updater_admin_id;
            $this->price_changed_at = $product->price_changed_at;
            $this->stat = $product->stat;
            $this->created_at = $product->created_at;
            $this->updated_at = $product->updated_at;
        }else{
            $this->status = ProductStatus::STATUS_ACTIVE;
            $this->state = ProductState::AVAILABLE;
            $this->imageForm = new ImageForm();
            $this->video = [];
            $this->similar = [];
            $this->imag = 0;
            $this->trust_percent = 10;
            $this->sort = 300;
            $this->currency_id = Currency::SUM;
        }

    }
}