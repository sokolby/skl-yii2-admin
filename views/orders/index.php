<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\search\UserSearch $searchModel
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Role $role
 */
$module = $this->context->module;
$user_model = $module->model("User");
$role_model = $module->model("Role");

$this->title = Yii::t('user', 'Заказы');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('user', 'Создать заказы', [
          'modelClass' => 'User',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user_id',
                'format'=>'raw',
                'value' => function($model, $index, $dataColumn) use ($user_model) {


                    $userDropdown = $user_model::findIdentity($model->user_id);

                    if(isset($userDropdown->email)){
                        return "<a href='/user/admin/view?id=".$userDropdown->id."' target='_blank'>".$userDropdown->email."</a> (".$userDropdown->id.")";
                    }else{
                        return '--Ошибка--';
                    }

                },
            ],
            'type',
            'time',
            [
                'attribute' => 'status',
                'format'=>'raw',
                'value' => function($model) {

                    switch ($model->status){
                        case 0:
                            $out = 'Проверяется';
                            break;
                        case 1:
                            $out = '<span style="color: orange">Подтвержден</span>';
                            break;
                        case 2:
                            $out = '<span style="color: green">Отправлен</span>';
                            break;
                    }

                    return $out;

                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
