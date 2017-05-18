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

$this->title = $receipt->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Чеки'), 'url' => ['/user/receipt/index']];
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
        <?= Html::a(Yii::t('user', 'Редактировать'), ['update', 'id' => $receipt->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $receipt->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Вы уверены что хотите удалить?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $receipt,
        'attributes' => [
            'id',
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
            'date',
            'img',
            'data',
            'status',
            'api_sent',
            'api_response',
        ],
    ]) ?>

</div>
