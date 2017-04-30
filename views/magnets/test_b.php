<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use pendalf89\filemanager\widgets\FileInput;

$this->title = Yii::t('user', 'Создание коллекции');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Коллекции'), 'url' => ['/user/magnets/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="customer-form">

        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
        <?= $form->field($modelCustomer, 'title')->textInput(['maxlength' => true]) ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($modelCustomer, 'grid_x')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelCustomer, 'grid_y')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($modelCustomer, 'size_x')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelCustomer, 'size_y')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h4> > Магниты</h4></div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 4, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsAddress[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'full_name',
                        'address_line1',
                        'address_line2',
                        'city',
                        'state',
                        'postal_code',
                    ],
                ]); ?>

                <div class="container-items"><!-- widgetContainer -->
                    <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Магнит</h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (! $modelAddress->isNewRecord) {
                                    echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                }
                                ?>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($modelAddress, "[{$i}]number")->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?=
                                        $form->field($modelAddress, "[{$i}]image")->widget(FileInput::className(), [
                                            'buttonTag' => 'button',
                                            'buttonName' => 'Обзор',
                                            'buttonOptions' => ['class' => 'btn btn-default'],
                                            'options' => ['class' => 'form-control'],
                                            // Widget template
                                            'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                            // Optional, if set, only this image can be selected by user
                                            'thumb' => 'original',
                                            // Optional, if set, in container will be inserted selected image
                                            'imageContainer' => '.img',
                                            // Default to FileInput::DATA_URL. This data will be inserted in input field
                                            'pasteData' => FileInput::DATA_URL,
                                            // JavaScript function, which will be called before insert file data to input.
                                            // Argument data contains file data.
                                            // data example: [alt: "Ведьма с кошкой", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
                                            'callbackBeforeInsert' => 'function(e, data) {
                                                console.log( data );
                                            }',
                                        ]);
                                        ?>
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>