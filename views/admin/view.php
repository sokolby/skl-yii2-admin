<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$this->title = $user->email;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Пользователи'), 'url' => ['index']];
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
        <?= Html::a(Yii::t('user', 'Редактировать'), ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $user->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Вы уверены что хотите удалить?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <p><h2>Информация о аккаунте:</h2></p>
    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            'id',
            'receipt_cond_agree',
            'has_sharebonus',
            [
                'attribute' => 'role_id',
                'value' => function ($model) {

                    switch ($model->role_id){
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
            [
                'attribute' => 'status',
                'value' => function ($model) {

                    switch ($model->status){
                        case 0:
                            $ret = 'Неактивен';
                            break;
                        case 1:
                            $ret = 'Активный';
                            break;
                        case 2:
                            $ret = 'Неподтверждённый email';
                            break;
                    }

                    return $ret;
                }
            ],
            'email:email',
            'username',
            'password',
            'auth_key',
            'access_token',
            'logged_in_ip',
            'logged_in_at',
            'created_ip',
            'created_at',
            'updated_at',
            'banned_at',
            'banned_reason',
        ],
    ]) ?>

    <p><h2>Информация о профиле:</h2></p>
    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            [
                'attribute'=>'profile.ava_src',
                'format'=>'raw',
                'value' => function ($model) {
                    $ret = '<a href="/uploads/'.$model->profile->ava_src.'" target="_blank">Открыть</a>';
                    return $ret;
                }
            ],
            'profile.surname',
            'profile.name',
            'profile.third_name',
            'profile.sex',
            'profile.bday_d',
            'profile.bday_m',
            'profile.bday_y',
            'profile.region',
            'profile.area',
            'profile.area_type',
            'profile.city',
            'profile.zip',
            'profile.str',
            'profile.house',
            'profile.housing',
            'profile.apt',
            'profile.phone',
            [
                'attribute' => 'profile.chkbxEmailMe',
                'format'=>'raw',
                'value' => function ($model) {

                    switch ($model->profile->chkbxEmailMe){
                        case 0:
                            $ret = '<span style="color: red">НЕ СОГЛАСЕН</span>';
                            break;
                        case 1:
                            $ret = '<span style="color: green">Согласен</span>';
                            break;
                    }

                    return $ret;
                }
            ],
            [
                'attribute' => 'profile.chkbxRules',
                'format'=>'raw',
                'value' => function ($model) {

                    switch ($model->profile->chkbxRules){
                        case 0:
                            $ret = '<span style="color: red">НЕ СОГЛАСЕН</span>';
                            break;
                        case 1:
                            $ret = '<span style="color: green">Согласен</span>';
                            break;
                    }

                    return $ret;
                }
            ],
            [
                'attribute' => 'profile.chkbxVek',
                'format'=>'raw',
                'value' => function ($model) {

                    switch ($model->profile->chkbxVek){
                        case 0:
                            $ret = '<span style="color: red">НЕ СОГЛАСЕН</span>';
                            break;
                        case 1:
                            $ret = '<span style="color: green">Согласен</span>';
                            break;
                    }

                    return $ret;
                }
            ]

        ],
    ]) ?>

</div>
