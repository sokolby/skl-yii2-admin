<?php

namespace amnah\yii2\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tbl_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $full_name
 * @property string $timezone
 *
 * @property User $user
 */
class Profile extends ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $imageFile;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name','surname','name','third_name','sex','region','area','area_type','city','zip','str','house','housing','apt','phone'], 'string', 'max' => 255],
            [['surname','name','third_name','sex','region','area_type','city','zip','str','house','apt','phone'], 'required'],
            [['bday_d','bday_m','bday_y','chkbxEmailMe','chkbxRules'],'integer'],
            [['bday_d','bday_m','bday_y','chkbxEmailMe','chkbxRules'],'required'],
            [['timezone'], 'string', 'max' => 255],
            //[["imageFile"], "file", "skipOnEmpty" => TRUE, "extensions" => "jpg, jpeg"],
            //[['imageFile'],'required'],
        ];
    }

    /**
     * @var \amnah\yii2\user\Module
     */
    public $module;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->module) {
            $this->module = Yii::$app->getModule("user");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'user_id' => Yii::t('user', 'User ID'),
            'created_at' => Yii::t('user', 'Created At'),
            'updated_at' => Yii::t('user', 'Updated At'),
            'full_name' => Yii::t('user', 'Полное имя'),
            'surname' => Yii::t('user', 'Фамилия'),
            'name' => Yii::t('user', 'Имя'),
            'third_name' => Yii::t('user', 'Отчество'),
            'sex' => Yii::t('user', 'Пол'),
            'imageFile' => Yii::t('user', 'Фото'),
            'bday_d' => Yii::t('user', 'День'),
            'bday_m' => Yii::t('user', 'Месяц'),
            'bday_y' => Yii::t('user', 'Год'),
            'region'  => Yii::t('user', 'Область'),
            'area' => Yii::t('user', 'Район'),
            'area_type' => Yii::t('user', 'Тип населенного пункта'),
            'city' => Yii::t('user', 'Населенный пункт'),
            'zip' => Yii::t('user', 'Индекс'),
            'str' => Yii::t('user', 'Улица'),
            'house' => Yii::t('user', 'Дом'),
            'housing' => Yii::t('user', 'Корпус'),
            'apt' => Yii::t('user', 'Квартира'),
            'phone' => Yii::t('user', 'Телефон'),
            'chkbxEmailMe' => Yii::t('user', 'Хочу получать сообщения об акциях "Расшишка"'),
            'chkbxRules' => Yii::t('user', 'Я согласен с условиями пользовательского соглашения'),
            'chkbxVek' => Yii::t('user', 'Хочу получать информацию о призах и акциях 21vek.by'),
            'timezone' => Yii::t('user', 'Time zone'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'value' => function ($event) {
                    return gmdate("Y-m-d H:i:s");
                },
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        $user = $this->module->model("User");
        return $this->hasOne($user::className(), ['id' => 'user_id']);
    }

    /**
     * Set user id
     * @param int $userId
     * @return static
     */
    public function setUser($userId)
    {
        $this->user_id = $userId;
        return $this;
    }


    public function upload()
    {

        if(isset($this->imageFile->baseName)){
            $file_n = $this->imageFile->baseName.'_'.date("Y_m_d_H_i_s");
            $this->imageFile->saveAs('uploads/' . $file_n . '.' . $this->imageFile->extension);
            return $file_n . '.' . $this->imageFile->extension;
        }else{
            return false;
        }



        $file_n = $this->imageFile->baseName.'_'.date("Y_m_d_H_i_s");

        //TODO: make validate
        //if ($this->validate()) {

        $this->imageFile->saveAs('uploads/' . $file_n . '.' . $this->imageFile->extension);
        return $file_n . '.' . $this->imageFile->extension;
        //} else {
        //    return false;
        //}

    }

}