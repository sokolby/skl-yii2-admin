<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */
$module = $this->context->module;
$user_model = $module->model("User");
$role_model = $module->model("Role");

$this->title = $log_activity->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Активность'), 'url' => ['/user/log_activity/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.detail-view th {
        width: 25%;
    }

    table.detail-view td {
        width: 75%;
    }
</style>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('user', 'Редактировать'), ['update', 'id' => $log_activity->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $log_activity->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Вы уверены что хотите удалить?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $log_activity,
        'attributes' => [
            'id',
            'date',
            [
                'attribute' => 'user_id',
                'format'=>'raw',
                'value' => function ($model) use ($user_model) {
                    $userDropdown = $user_model::findIdentity($model->user_id);

                    if(isset($userDropdown->email)){
                        return "<a href='/user/admin/view?id=".$userDropdown->id."'>".$userDropdown->email."</a> ID=".$userDropdown->id;
                    }else{
                        return '--Ошибка--';
                    }

                }
            ],
            [
                'attribute' => 'user_role',
                'format'=>'raw',
                'value' => function ($model) use ($user_model) {

                    switch ($model->user_role){
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
        ],
    ]) ?>

</div>
