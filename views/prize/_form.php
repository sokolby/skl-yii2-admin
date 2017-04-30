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

    <?= $form->field($user, 'title')->textInput(['maxlength' => 255]) ?>



    <?= $form->field($user, 'post_status')->dropDownList([0=>'Скрыт',1=>'опубликован'])?>

    <?= $form->field($user, 'desc')->textarea() ?>

    <?= $form->field($user, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('') ?>

    <?= $form->field($user, 'price')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($user, 'price_delivery')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>