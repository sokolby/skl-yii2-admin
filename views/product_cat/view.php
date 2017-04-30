<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$this->title = $prod_cat->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Продукты'), 'url' => ['/user/product/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Категория'), 'url' => ['/user/product_cat/index']];
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
        <?= Html::a(Yii::t('user', 'Редактировать'), ['update', 'id' => $prod_cat->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $prod_cat->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Вы уверены что хотите удалить?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $prod_cat,
        'attributes' => [
            'id',
            'title',
            'desc'
        ],
    ]) ?>

</div>
