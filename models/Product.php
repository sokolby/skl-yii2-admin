<?php

namespace amnah\yii2\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use yii\helpers\Inflector;
use ReflectionClass;


class Product extends ActiveRecord
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
            $this->module = Yii::$app->getModule("post_product");
        }
    }

    public function rules()
    {
        // set initial rules
        $rules = [
            // general email and username rules
            [['title', 'desc','consist','items'], 'string'],
            [['category_id','position'], 'integer'],
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
            'position' => Yii::t('user', 'Позиция'),
            'desc' => Yii::t('user', 'Описание'),
            'consist' => Yii::t('user', 'Состав'),
            'items' => Yii::t('user', 'Варианты'),
            'category_id' => Yii::t('user', 'Категория'),
        ];
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'post_product';
    }

}