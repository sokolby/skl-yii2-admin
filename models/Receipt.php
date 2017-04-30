<?php

namespace amnah\yii2\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use yii\helpers\Inflector;
use ReflectionClass;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;


class Receipt extends ActiveRecord
{


    /**
     * @var \amnah\yii2\user\Module
     */
    public $module;
    public $imageFiles;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->module) {
            $this->module = Yii::$app->getModule("post_receipt");
        }
    }

    public function rules()
    {
        // set initial rules
        $rules = [
            // general email and username rules
            [['img','data','date'], 'string'],
            [['user_id','status'], 'integer'],
            //[["imageFile"], "file", "skipOnEmpty" => TRUE, "extensions" => "jpg, jpeg"],
            //[['imageFile'],'required'],
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'img' => Yii::t('user', 'Картинка'),
            'data' => Yii::t('user', 'Продукты'),
            'date' => Yii::t('user', 'Время'),
            'user_id' => Yii::t('user', 'Пользователь'),
            'status' => Yii::t('user', 'Статус'),
            'imageFiles' => Yii::t('user', 'Фото чеков'),
        ];
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'post_receipt';
    }

    public function upload($uid)
    {

        $files_list = [];
        foreach ($this->imageFiles as $file) {

            $path = 'user_receipt/'. $uid;
            FileHelper::createDirectory($path);

            $file_n = $uid.'_'.$file->baseName.'_'.date("Y_m_d_H_i_s");
            $file->saveAs($path.'/' . $file_n . '.' . $file->extension);
            $files_list[] = $file_n . '.' . $file->extension;
        }

        return $files_list;

    }

}