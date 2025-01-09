<?php

namespace merchant\models\forms;

use common\helpers\Utilities;
use common\models\constants\CustomerStatus;
use common\models\Customer;
use common\models\CustomerCard;
use common\models\CustomerImage;
use common\models\CustomerPassport;
use common\models\CustomerUpload;
use common\models\CustomerWork;
use common\models\Relative;
use Yii;
use yii\base\Model;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $pin
 * @property int $city_id
 * @property int $region_id
 * @property int $address
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $birth_date
 * @property string $phone
 * @property string $extra_phone
 * @property int $family_status
 * @property string $image
 * @property int $status
 * @property int $company_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string $temp_image
 * @property string $temp_text
 * @property string $which
 *
 * @property Relative[] $relatives
 * @property CustomerCard[] $customer_cards
 * @property Customer $_customer
 * @property CustomerUpload[] $customer_uploads
 * @property CustomerImage[] $customer_images
 * @property CustomerWork[] $customer_works
 * @property CustomerPassport[] $customer_passports
 */
class CustomerForm extends Model
{
    public $id;
    public $pin;
    public $city_id;
    public $region_id;
    public $address;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $birth_date;
    public $phone;
    public $extra_phone;
    public $family_status;
    public $image;
    public $status;
    public $created_at;
    public $updated_at;
    public $relatives;
    public $customer_cards;
    public $customer_uploads;
    public $customer_images;
    public $customer_works;
    public $customer_passports;
    public $temp_image;
    public $temp_text;
    public $company_id;
    public $which;
    public $_customer;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pin', 'city_id', 'region_id', 'address', 'first_name', 'last_name', 'middle_name', 'phone', 'customer_passports'], 'required'],
            [['city_id', 'region_id', 'address', 'family_status', 'status', 'created_at', 'updated_at', 'extra_phone'], 'default', 'value' => null],
            [['city_id', 'region_id', 'family_status', 'status', 'created_at', 'updated_at'], 'integer'],
            [['pin', 'first_name', 'last_name', 'middle_name', 'image', 'address', 'which'], 'string', 'max' => 255],
            [['phone', 'extra_phone'], 'match', 'pattern' => '/((\+998)|0)[-]?[0-9]{9}/'],
            [['relatives', 'customer_cards', 'customer_uploads', 'customer_images', 'customer_works', 'customer_passports', 'birth_date'], 'safe'],
            ['pin', 'unique', 'targetClass' => Customer::className(),
                'message' => 'Ushbu xaridor oldindan mavjud', 'when' => function ($model) {
                return !$model->id;
            }],
            [['temp_image', 'temp_text'], 'string', 'max' => 1024]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pin' => Yii::t('app', 'Pin'),
            'city_id' => Yii::t('app', 'City ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'address' => Yii::t('app', 'Address'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'phone' => Yii::t('app', 'Phone'),
            'extra_phone' => Yii::t('app', 'Extra') . ' ' . Yii::t('app', 'Phone'),
            'family_status' => Yii::t('app', 'Family Status'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'relatives' => Yii::t('app', 'Relatives'),
            'customer_cards' => Yii::t('app', 'Customer cards'),
            'customer_uploads' => Yii::t('app', 'Customer uploads'),
            'customer_images' => Yii::t('app', 'Customer images'),
            'customer_works' => Yii::t('app', 'Customer works'),
            'customer_passports' => Yii::t('app', 'Customer passports'),
        ];
    }

    /**
     * @param Customer $customer
     * @return Relative[]
     */
    public function downloadRelatives(Customer $customer)
    {
        $relatives = [];
        foreach ($customer->relatives as $relative) {
            $relatives[] = [
                "id" => $relative->id,
                "office" => $relative->office,
                "position" => $relative->position,
                "full_name" => $relative->full_name,
                "who_is" => $relative->who_is,
                "phone" => $relative->phone,
            ];
        }
        return $relatives;
    }

    /**
     * @param Customer $customer
     * @return CustomerCard[]
     */
    public function downloadCustomer_cards(Customer $customer)
    {
        $customer_cards = [];
        foreach ($customer->customer_cards as $customer_card) {

            $customer_cards[] = [
                "id" => $customer_card->id,
                "holder" => $customer_card->holder,
                "cv1" => '$' . substr($customer_card->cv, 3, 2),
                "cv2" => substr($customer_card->cv, 0, 2),
                "bank" => $customer_card->bank,
                "status" => $customer_card->status,
            ];
        }
        return $customer_cards;
    }

    /**
     * @param Customer $customer
     * @return CustomerUpload[]
     */
    public function downloadCustomer_uploads(Customer $customer)
    {
        $customer_uploads = [];
        foreach ($customer->customer_uploads as $customer_upload) {
            $customer_uploads[] = [
                "id" => $customer_upload->id,
                "name" => $customer_upload->name,
                "file" => $customer_upload->file,
                "type" => $customer_upload->type,
            ];
        }
        return $customer_uploads;
    }

    /**
     * @param Customer $customer
     * @return CustomerImage[]
     */
    public function downloadCustomer_images(Customer $customer)
    {
        $customer_images = [];
        foreach ($customer->customer_images as $customer_image) {
            $customer_images[] = [
                "id" => $customer_image->id,
                "name" => $customer_image->name,
                "file" => $customer_image->file,
                "type" => $customer_image->type,
            ];
        }
        return $customer_images;
    }

    /**
     * @param Customer $customer
     * @return CustomerWork[]
     */
    public function downloadCustomer_works(Customer $customer)
    {
        $customer_works = [];
        foreach ($customer->customer_works as $customer_work) {
            $customer_works[] = [
                "id" => $customer_work->id,
                "work_city_id" => $customer_work->work_city_id,
                "work_region_id" => $customer_work->work_region_id,
                "work_address" => $customer_work->work_address,
                "office" => $customer_work->office,
                "position" => $customer_work->position,
                "salary" => $customer_work->salary,
                "status" => $customer_work->status,
            ];
        }

        return $customer_works;
    }

    /**
     * @param Customer $customer
     * @return CustomerPassport[]
     */
    public function downloadCustomer_passports(Customer $customer)
    {
        $customer_passports = [];
        foreach ($customer->customer_passports as $customer_passport) {
            $customer_passports[] = [
                "id" => $customer_passport->id,
                "passport_seria" => mb_strtoupper($customer_passport->passport_seria, "utf-8"),
                "passport_number" => $customer_passport->passport_number,
                "passport_copyright" => $customer_passport->passport_copyright,
                "birth_date" => date("d.m.Y", $customer->birth_date),
                "passport_given_date" => date("d.m.Y", $customer_passport->passport_given_date),
                "status" => $customer_passport->status,
            ];
        }
        return $customer_passports;
    }

    /**
     * QuestionForm constructor.
     * @param Customer|null $customer
     */
    public function __construct(Customer $customer = null)
    {
        if ($customer) {
            $this->_customer = $customer;
            $this->id = $customer->id;
            $this->pin = $customer->pin;
            $this->city_id = $customer->city_id;
            $this->region_id = $customer->region_id;
            $this->address = $customer->address;
            $this->first_name = mb_strtoupper($customer->first_name, "utf-8");
            $this->last_name = mb_strtoupper($customer->last_name, "utf-8");
            $this->middle_name = mb_strtoupper($customer->middle_name, "utf-8");
            $this->phone = $customer->phone;
            $this->extra_phone = $customer->extra_phone;
            $this->family_status = $customer->family_status;
            $this->status = $customer->status;
            $this->birth_date = date("d.m.Y", $customer->birth_date);
            $this->relatives = $this->downloadRelatives($customer);
            $this->customer_uploads = $this->downloadCustomer_uploads($customer);
            $this->image = $this->downloadCustomer_images($customer);
            $this->customer_works = $this->downloadCustomer_works($customer);
            $this->customer_passports = $this->downloadCustomer_passports($customer);
        } else {
            $this->relatives = [];
            $this->customer_cards = [];
            $this->customer_uploads = [];
            $this->customer_images = [];
            $this->customer_works = [];
            $this->customer_passports = [];
            $this->status = CustomerStatus::STATUS_MEMBER;
            $this->temp_image = '/no-photo.png';
            $this->image = '/no-photo.png';
            $this->phone = "+998";
            $this->extra_phone = "+998";
            $this->pin = $this->randString(14);
        }
        $this->company_id = Yii::$app->user->identity->company_id;
        $this->which = 'main';
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!is_array($this->relatives))
            $this->relatives = [];
        if (!is_array($this->customer_works))
            $this->customer_works = [];
        if (!is_array($this->customer_passports))
            $this->customer_passports = [];

        if ($this->id)
            $customer = Customer::findOne($this->id);
        else
            $customer = new Customer();
        $customer->pin = $this->pin;
        $customer->is_pin_null = $this->pin == null || $this->pin == '' || strlen($this->pin) < 1 || !is_numeric($this->pin) ? true : false;
        if ($customer->is_pin_null)
            $customer->pin = $this->randString(255);
        $customer->city_id = $this->city_id;
        $customer->region_id = $this->region_id;
        $customer->address = $this->address;
        $customer->first_name = mb_strtoupper($this->first_name, "utf-8");
        $customer->last_name = mb_strtoupper($this->last_name, "utf-8");
        $customer->middle_name = mb_strtoupper($this->middle_name, "utf-8");
        $customer->phone = $this->phone;
        $customer->extra_phone = $this->extra_phone;
        $customer->family_status = $this->family_status;
        $customer->status = $this->status;
        $customer->birth_date = Utilities::toUnixDate($this->birth_date);
        if ($customer->save()) {
            $this->id = $customer->id;
            $this->uploadRelatives();
            $this->uploadCustomer_works();
            if (!$this->uploadCustomer_passports()) {
                Customer::deleteAll(['id' => $customer->id]);
            }
            return true;
        }
        echo "on customer";
        var_dump($customer->errors);
        die;
        return false;
    }

    public function uploadRelatives()
    {
        $ids = [];
        foreach ($this->relatives as $relative)
            if ($relative['id'] != '-1')
                $ids[] = $relative['id'];
        Relative::deleteAll(['and', ['not', ['in', 'id', $ids]], ['customer_id' => $this->id], ['company_id' => $this->company_id]]);
        foreach ($this->relatives as $relative) {
            $customer_relative = new Relative();
            $customer_relative->company_id = $this->company_id;
            if ($relative['id'] != '-1') {
                if (Yii::$app->user->identity->is_president)
                    $customer_relative = Relative::findOne($relative['id']);
                else
                    continue;
            }
            if ($customer_relative->company_id != $this->company_id)
                continue;
            $customer_relative->customer_id = $this->id;
            $customer_relative->full_name = $relative['full_name'];
            $customer_relative->office = $relative['office'];
            $customer_relative->position = $relative['position'];
            $customer_relative->who_is = $relative['who_is'];
            $customer_relative->phone = $relative['phone'];
            if (!$customer_relative->save()) {
//                echo "<pre>";
//                var_dump($customer_relative->errors);
//                die;
            }
        }
    }

    public function uploadCustomer_cards()
    {
        $ids = [];
        foreach ($this->customer_cards as $customer_card)
            if ($customer_card['id'] != '-1')
                $ids[] = $customer_card['id'];
        CustomerCard::deleteAll(['and', ['not', ['in', 'id', $ids]], ['customer_id' => $this->id], ['company_id' => $this->company_id]]);
        foreach ($this->customer_cards as $card) {
            $customer_card = new CustomerCard();
            $customer_card->company_id = $this->company_id;
            if ($card['id'] != '-1')
                continue;
            if ($customer_card->company_id != $this->company_id)
                continue;
            $customer_card->customer_id = $this->id;
            $customer_card->holder = $card['holder'];
            $customer_card->cv = $card['cv2'] . $card['cv1'];
            $customer_card->bank = $card['bank'];
            $customer_card->status = $card['status'];
            if (!$customer_card->save()) {
//                echo "<pre>";
//                var_dump($customer_card->errors);
//                die;
            }
        }
    }

    public function uploadCustomer_uploads()
    {
        $ids = [];
        foreach ($this->customer_uploads as $customer_upload)
            if ($customer_upload['id'] != '-1')
                $ids[] = $customer_upload['id'];
        CustomerUpload::deleteAll(['and', ['not', ['in', 'id', $ids]], ['customer_id' => $this->id], ['company_id' => $this->company_id]]);
        foreach ($this->customer_uploads as $upload) {
            $customer_upload = new CustomerUpload();
            $customer_upload->company_id = $this->company_id;
            if ($upload['id'] != '-1')
                $customer_upload = CustomerUpload::findOne($upload['id']);
            if ($customer_upload->company_id != $this->company_id)
                continue;
            $customer_upload->customer_id = $this->id;
            $customer_upload->name = $upload['name'];
            $customer_upload->file = $upload['file'];
            $customer_upload->type = $upload['type'];
            if (!$customer_upload->save()) {
//                echo "<pre>";
//                var_dump($customer_upload->errors);
//                die;
            }
        }
    }

    public function uploadCustomer_images()
    {
        $ids = [];
        foreach ($this->customer_images as $customer_image)
            if ($customer_image['id'] != '-1')
                $ids[] = $customer_image['id'];
        CustomerImage::deleteAll(['and', ['not', ['in', 'id', $ids]], ['customer_id' => $this->id], ['company_id' => $this->company_id]]);
        foreach ($this->customer_images as $image) {
            $customer_image = new CustomerImage();
            $customer_image->company_id = $this->company_id;
            if ($image['id'] != '-1')
                $customer_image = CustomerImage::findOne($image['id']);
            if ($customer_image->company_id != $this->company_id)
                continue;
            $customer_image->customer_id = $this->id;
            $customer_image->name = $image['name'];
            $customer_image->file = $image['file'];
            $customer_image->type = $image['type'];
            if (!$customer_image->save()) {
//                echo "<pre>";
//                var_dump($customer_image->errors);
//                die;
            }
        }
    }

    public function uploadCustomer_works()
    {
        $ids = [];
        foreach ($this->customer_works as $customer_work)
            if ($customer_work['id'] != '-1')
                $ids[] = $customer_work['id'];
        CustomerWork::deleteAll(['and', ['not', ['in', 'id', $ids]], ['customer_id' => $this->id], ['company_id' => $this->company_id]]);
        foreach ($this->customer_works as $work) {
            if (!isset($work['work_city_id']) || $work['work_city_id'] == null)
                continue;
            $customer_work = new CustomerWork();
            $customer_work->company_id = $this->company_id;
            if ($work['id'] != '-1')
                $customer_work = CustomerWork::findOne($work['id']);
            if ($customer_work->company_id != $this->company_id)
                continue;
            $customer_work->customer_id = $this->id;
            $customer_work->work_region_id = $work['work_region_id'];
            $customer_work->work_city_id = $work['work_city_id'];
            $customer_work->work_address = $work['work_address'];
            $customer_work->office = $work['office'];
            $customer_work->position = $work['position'];
            $customer_work->salary = $work['salary'];
            $customer_work->status = $work['status'];
            if (!$customer_work->save()) {
//                echo "<pre>";
//                var_dump($customer_work->errors);
//                die;
            }
        }
    }


    public function uploadCustomer_passports()
    {
        $ids = [];
        foreach ($this->customer_passports as $customer_passport)
            if ($customer_passport['id'] != '-1')
                $ids[] = $customer_passport['id'];
        CustomerPassport::deleteAll(['and', ['not', ['in', 'id', $ids]], ['customer_id' => $this->id], ['company_id' => $this->company_id]]);
        foreach ($this->customer_passports as $passport) {
            $customer_passport = new CustomerPassport();
            $customer_passport->company_id = $this->company_id;
            if ($passport['id'] != '-1')
                $customer_passport = CustomerPassport::findOne($passport['id']);
            if ($customer_passport->company_id != $this->company_id)
                continue;
            $customer_passport->customer_id = $this->id;
            $customer_passport->passport_seria = mb_strtoupper($passport['passport_seria'],"utf-8");
            $customer_passport->passport_number = $passport['passport_number'];
            $customer_passport->passport_copyright = $passport['passport_copyright'];
            $customer_passport->passport_given_date = Utilities::toUnixDate($passport['passport_given_date']);
            $customer_passport->status = $passport['status'];
            if (!$customer_passport->save()) {
                echo "on passport";
                var_dump($customer_passport->errors);
                die;
                return false;
            }
        }
        return true;
    }

    /**
     * @return string
     */
    public function getFull_name()
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . $this->middle_name;
    }

    /**
     * @param $length
     * @return string
     */
    public function randString($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param $customer
     */
    public function setByApi($customer)
    {
        if (!isset($customer['pin']))
            $customer['pin'] = [];

        $this->relatives = $customer['relatives'];
        $this->customer_works = $customer['customer_works'];
        $this->customer_passports = $customer['customer_passports'];
        $this->customer_cards = $customer['customer_cards'];

        $this->pin = $customer['pin'];
        $this->city_id = $customer['city_id'];
        $this->region_id = $customer['region_id'];
        $this->address = $customer['address'];
        $this->first_name = $customer['first_name'];
        $this->last_name = $customer['last_name'];
        $this->middle_name = $customer['middle_name'];
        $this->phone = $customer['phone'];
        $this->extra_phone = $customer['extra_phone'];
        $this->family_status = $customer['family_status'];
        $this->status = $customer['status'];
        $this->birth_date = $customer['birth_date'];
    }
}
