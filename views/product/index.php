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
$user = $module->model("User");
$prod_cat = $module->model("ProdCat");

$this->title = Yii::t('user', 'Продукты');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('user', 'Управление категориями', [
            'modelClass' => 'User',
        ]), ['/user/product_cat/index'], ['class' => 'btn btn-default']) ?>

        <?= Html::a(Yii::t('user', 'Создать продукт', [
          'modelClass' => 'User',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'position',
            [
                'attribute' => 'category_id',
                'filter' => $prod_cat::dropdown(),
                'value' => function($model, $index, $dataColumn) use ($prod_cat) {
                    $prodCatDropdown = $prod_cat::dropdown();

                    if(isset($prodCatDropdown[$model->category_id])){
                        return $prodCatDropdown[$model->category_id];
                    }else{
                        return '--Категория не найдена--';
                    }

                },
            ],
            'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
