<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 * @var amnah\yii2\user\models\Role $role
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->field($user, 'user_id')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($user, 'time')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($user, 'item')->textInput() ?>


    <?= $form->field($user, 'status')->dropDownList([0=>'Проверяется',1=>'Подтвержден',2=>'Отправлен']) ?>

    <?= $form->field($user, 'informed')->dropDownList([0=>'Нет',1=>'Да']) ?>

    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>