<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = Yii::t('user', 'Создание коллекции');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Коллекции'), 'url' => ['/user/magnets/index']];
$this->params['breadcrumbs'][] = $this->title;

$modelCatalogOption = $modelCustomer;
?>

<div class="customer-form">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'validateOnChange' => true,
        'validateOnBlur' => false,
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'dynamic-form'
        ]
    ]); ?>

    <?= $form->field($modelCatalogOption, 'title')->textInput(['maxlength' => true]) ?>


    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($modelCatalogOption, 'grid_x')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCatalogOption, 'grid_y')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($modelCatalogOption, 'size_x')->textInput(['maxlength' => true]) ?>

            <?= $form->field($modelCatalogOption, 'size_y')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

    <?= $this->render('_form_option_values', [
        'form' => $form,
        'modelCatalogOption' => $modelCatalogOption,
        'modelsOptionValue' => $modelsAddress
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($modelCatalogOption->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>