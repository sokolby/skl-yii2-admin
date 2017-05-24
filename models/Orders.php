<?php

namespace amnah\yii2\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use yii\helpers\Inflector;
use ReflectionClass;


class Orders extends ActiveRecord
{


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
            $this->module = Yii::$app->getModule("post_orders");
        }
    }

    public function rules()
    {
        // set initial rules
        $rules = [
            // general email and username rules
            [['time','item','type'], 'string'],
            [['user_id','status','informed'], 'integer'],
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'time' => Yii::t('user', 'Время'),
            'type' => Yii::t('user', 'Тип'),
            'item' => Yii::t('user', 'Корзина'),
            'user_id' => Yii::t('user', 'Пользователь'),
            'status' => Yii::t('user', 'Статус'),
            'informed' => Yii::t('user', 'Отправлен e-mail?')
        ];
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'post_orders';
    }

}