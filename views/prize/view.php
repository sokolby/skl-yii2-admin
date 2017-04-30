<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$this->title = $prize->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Призы'), 'url' => ['/user/prize/index']];
$this->params['breadcrumbs'][] = $this->title;

$module = $this->context->module;
$prod_cat = $module->model("ProdCat");
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
        <?= Html::a(Yii::t('user', 'Редактировать'), ['update', 'id' => $prize->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $prize->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Вы уверены что хотите удалить?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $prize,
        'attributes' => [
            'id',
            'title',
            'img',
            'price',
            'price_delivery',

        ],
    ]) ?>

</div>
