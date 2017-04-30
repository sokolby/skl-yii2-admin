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
$user = $module->model("ProdCat");

$this->title = Yii::t('user', 'Категории продкутов');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Продукты'), 'url' => ['/user/product/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= Html::a(Yii::t('user', 'Управление продуктами', [
            'modelClass' => 'User',
        ]), ['/user/product/index'], ['class' => 'btn btn-default']) ?>

        <?= Html::a(Yii::t('user', 'Создать категорию', [
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
            'title',
            'desc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
