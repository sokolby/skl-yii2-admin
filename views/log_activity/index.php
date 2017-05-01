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

$this->title = Yii::t('user', 'Активность');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Коды: <br/>
        1 - Авторизация<br/>
        2 - Регистрация<br/>
        3 - Задачи по расписания
    </p>

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            [
                'attribute' => 'user_id',
                'format'=>'raw',
                'value' => function($model, $index, $dataColumn) use ($user_model) {


                    $userDropdown = $user_model::findIdentity($model->user_id);

                    if(isset($userDropdown->email)){
                        return "<a href='/user/admin/view?id=".$userDropdown->id."' target=\"_blank\">".$userDropdown->email."</a> (".$userDropdown->id.")";
                    }else{
                        return '--Ошибка--';
                    }

                },
            ],
            [
                'attribute' => 'role_id',
                'filter' => $role_model::dropdown(),
                'value' => function ($model) use ($user_model) {

                    switch ($model->user_role){
                        case 0:
                            $ret = 'Root';
                            break;
                        case 1:
                            $ret = 'Администратор';
                            break;
                        case 2:
                            $ret = 'Пользователь';
                            break;
                    }

                    return $ret;
                }
            ],
            'ip',
            'code',
            [
                'class' => \yii\grid\ActionColumn::className(),
                'template'=>'{view} {delete}'
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
