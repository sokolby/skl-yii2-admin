<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Редактировать категорию продуктов: ', [
  'modelClass' => 'User',
]) . ' ' . $user->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Продукты'), 'url' => ['/user/product/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Категория'), 'url' => ['/user/product_cat/index']];
$this->params['breadcrumbs'][] = ['label' => $user->title, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Редактирование');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'user' => $user
    ]) ?>

</div>
