<?php


namespace merchant\models\forms;

use common\models\CustomerImage;
use common\models\ImagesType;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUploadForm extends Model
{
    public $file;
    public $fileName = 'Passport';
    public $formats = 'png, jpg, jpeg, gif';
    public $maxSize = 10485760;

    /**
     * ImageUploadForm constructor.
     * @param $fileName
     * @param string $formats
     * @param int $maxSize
     */
    public function __construct($fileName, $formats = 'png, jpg, jpeg, gif', $maxSize = 10485760)
    {
        $this->fileName = $fileName;
        $this->formats = $formats;
        $this->maxSize = $maxSize;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => $this->formats, 'maxSize' => $this->maxSize],
            [['file'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file' => $this->fileName
        ];
    }

    /**
     * @return bool|string
     */
    public function uploader()
    {

        try {
            $this->file = UploadedFile::getInstance($this, 'file');
            $fileName = $this->file->baseName . time() . '.' . $this->file->extension;
            $inputFile = \Yii::getAlias('@assets/customer/image/') . $fileName;
            if ($this->file && $this->validate()) {
                $this->file->saveAs($inputFile);
                return \Yii::getAlias('@assets_url/customer/image/') . $fileName;
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * @param $customer_id
     * @param ImagesType $type
     * @return bool
     */
    public function save($customer_id, ImagesType $type)
    {
        $fileName = $this->uploader();
        if (!$fileName)
            return false;
        $image = new CustomerImage();
        $image->company_id = \Yii::$app->user->identity->company_id;
        $image->customer_id = $customer_id;
        if($image->type == 5)
            $image->type = 10;
        $image->type = $type->id;
        $image->name = $type->name;
        $image->file = $fileName;
        return $image->save();
    }

}