<?php

namespace amnah\yii2\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use yii\helpers\Inflector;
use ReflectionClass;


class ProdCat extends ActiveRecord
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
            $this->module = Yii::$app->getModule("post_product_cat");
        }
    }

    public function rules()
    {
        // set initial rules
        $rules = [
            // general email and username rules
            [['title', 'desc'], 'string'],
            [['id'], 'integer'],
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID категории'),
            'title' => Yii::t('user', 'Заголовок'),
            'desc' => Yii::t('user', 'Описание'),
        ];
    }

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'post_product_cat';
    }

    /**
     * Get list of roles for creating dropdowns
     * @return array
     */
    public static function dropdown()
    {
        // get all records from database and generate
        static $dropdown;
        if ($dropdown === null) {
            $models = static::find()->all();
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->title;
            }
        }
        return $dropdown;
    }

}