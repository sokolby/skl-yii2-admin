<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Начисление баллов');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Бонусный баллы'), 'url' => ['/user/points/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'user_id')->textInput(['maxlength' => 255])->label('ID пользователя') ?>

        <?= $form->field($user, 'amount')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($transaction, 'desc')->textInput(['maxlength' => 255]) ?>

        <div class="form-group">
            <?= Html::submitButton('Начислить', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>