<?php

namespace amnah\yii2\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use yii\helpers\Inflector;
use ReflectionClass;


class Points extends ActiveRecord
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
            $this->module = Yii::$app->getModule("user_points");
        }
    }

    public function rules()
    {
        // set initial rules
        $rules = [
            // general email and username rules
            [['last_update'], 'string'],
            [['user_id','amount'], 'integer'],
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('user', 'Пользователь'),
            'amount' => Yii::t('user', 'Баланс'),
            'last_update' => Yii::t('user', 'Обновлены'),
        ];
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'user_points';
    }

}