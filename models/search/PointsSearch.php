<?php

namespace amnah\yii2\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use amnah\yii2\user\models\User;

/**
 * UserSearch represents the model behind the search form about `amnah\yii2\user\models\User`.
 */
class PointsSearch extends User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%user_points}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_update'], 'string'],
            [['user_id','amount'], 'integer'],
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
        $user = $this->module->model("Points");
        $profile = $this->module->model("Profile");
        $userTable = $user::tableName();
        $profileTable = $profile::tableName();

        // set up query relation for `user`.`profile`
        // http://www.yiiframework.com/doc-2.0/guide-output-data-widgets.html#working-with-model-relations
        $query = $user::find();


        //$query->joinWith(['profile' => function ($query) use ($profileTable) {
        //    $query->from(['profile' => $profileTable]);
        //}]);


        //$page_size = 5;

        // create data provider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => [
            //    'pageSize' => $page_size,
            //]
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
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'last_update', $this->last_update])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'amount', $this->amount]);

        return $dataProvider;
    }
}