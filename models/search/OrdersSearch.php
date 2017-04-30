<?php

namespace amnah\yii2\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use amnah\yii2\user\models\User;

/**
 * UserSearch represents the model behind the search form about `amnah\yii2\user\models\User`.
 */
class OrdersSearch extends User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%post_orders}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time','item'], 'string'],
            [['user_id','status'], 'integer'],
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
        $user = $this->module->model("Orders");
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
            "{$userTable}.id" => $this->id,
            'title' => $this->title,
            'desc' => $this->desc,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', "profile.full_name", $this->getAttribute('profile.full_name')]);

        return $dataProvider;
    }
}