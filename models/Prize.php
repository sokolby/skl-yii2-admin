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


class Prize extends ActiveRecord
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
            $this->module = Yii::$app->getModule("post_prize");
        }
    }

    public function rules()
    {
        // set initial rules
        $rules = [
            // general email and username rules
            [['title','price','desc','price_delivery','img'], 'string'],
            [['post_status'],'integer']
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('user', 'Заголовок'),
            'post_status' => Yii::t('user', 'Статус'),
            'img' => Yii::t('user', 'Картинка'),
            'desc' => Yii::t('user', 'Описание'),
            'price' => Yii::t('user', 'Цена'),
            'price_delivery' => Yii::t('user', 'Цена с доставкой')
        ];
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'post_prize';
    }

    public function upload()
    {

        $files_list = [];
        foreach ($this->imageFiles as $file) {

            $file_n = $file->baseName.'_'.date("Y_m_d_H_i_s");
            $file->saveAs('uploads/assets/'. $file_n . '.' . $file->extension);
            $files_list[] = $file_n . '.' . $file->extension;
        }

        return $files_list;

    }
}