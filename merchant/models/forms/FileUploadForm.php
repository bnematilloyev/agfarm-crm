<?php


namespace merchant\models\forms;

use common\models\ImagesType;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class FileUploadForm extends Model
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'pdf', 'maxSize' => 10485760],
            [['file'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file' => $this->file
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
            $inputFile = Yii::getAlias('@assets/page/') . $fileName;
            if ($this->file && $this->validate()) {
                $this->file->saveAs($inputFile);
                return Yii::getAlias('@assets/page/') . $fileName;
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
    public function save($file)
    {
        $fileName = $this->uploader();
        if (!$fileName)
            return false;

        $this->file = $fileName;
        return $$this->file->save();
    }

}