<?php

namespace amnah\yii2\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use amnah\yii2\user\models\User;

/**
 * UserSearch represents the model behind the search form about `amnah\yii2\user\models\User`.
 */
class LogActivitySearch extends User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%log_user_activity}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip'], 'string'],
            [['user_id','code'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['profile.full_name']);
    }

    /**
     * Search
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /** @var \amnah\yii2\user\models\User $user */
        /** @var \amnah\yii2\user\models\Profile $profile */

        // get models
        $user = $this->module->model("LogActivity");

        // set up query relation for `user`.`profile`
        // http://www.yiiframework.com/doc-2.0/guide-output-data-widgets.html#working-with-model-relations
        $query = $user::find();


        // create data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // enable sorting for the related columns
        $addSortAttributes = ["profile.full_name"];
        foreach ($addSortAttributes as $addSortAttribute) {
            $dataProvider->sort->attributes[$addSortAttribute] = [
                'asc' => [$addSortAttribute => SORT_ASC],
                'desc' => [$addSortAttribute => SORT_DESC],
            ];
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ip' => $this->ip,
            'user_id' => $this->user_id,
            'code' => $this->code

        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}