<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use pendalf89\filemanager\widgets\FileInput;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 * @var amnah\yii2\user\models\Role $role
 * @var yii\widgets\ActiveForm $form
 */


if(isset($user->attributes['items'])){
    $items = json_decode($user->attributes['items']);
}



?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->field($user, 'title')->textInput(['maxlength' => 255]) ?>

    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($user, 'grid_x')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($user, 'grid_y')->textInput(['maxlength' => 255]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($user, 'size_x')->textInput(['maxlength' => 255]) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($user, 'size_y')->textInput(['maxlength' => 255]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>Магниты</h4>
            <div class="repeat">
                <table class="wrapper table table-striped table-bordered" width="100%">
                    <thead>
                    <tr>
                        <td width="10%" colspan="4"><span class="add btn btn-success">Добавить вариант</span></td>
                    </tr>
                    </thead>
                    <tbody class="container">



                    <tr class="template row">
                        <td width="10%"><span class="move" style="cursor: move"><span class="glyphicon glyphicon-move"></span>Переместить</span></td>

                        <td width="80%">
                            <dl>
                                <dt>Номер</dt>
                                <dd> <input type="text" class="form-control" name="Magnets[items][{{row-count-placeholder}}][number]" /></dd>

                                <dt>Ссылка на картинку</dt>
                                <dd> <input type="text" class="form-control" name="Magnets[items][{{row-count-placeholder}}][image]" /></dd>

                            </dl>

                        </td>

                        <td width="10%"><span class="remove btn btn-danger">Удалить</span></td>
                    </tr>


                    <?php if(isset($items)): foreach ($items as $index=>$sl):?>
                        <tr class="row">
                            <td width="10%"><span class="move" style="cursor: move"><span class="glyphicon glyphicon-move"></span>Переместить</span></td>

                            <td width="80%">
                                <dl>
                                    <dt>Номер</dt>
                                    <dd> <input type="text" class="form-control" name="Magnets[items][<?=$index?>][number]" value="<?=$sl->number?>"/></dd>


                                    <?php
                                    echo FileInput::widget([
                                        'name' => 'Magnets[items]['.$index.'][image]',
                                        'value' => $sl->image,
                                        'buttonTag' => 'button',
                                        'buttonName' => 'Обзор',
                                        'buttonOptions' => ['class' => 'btn btn-default'],
                                        'options' => ['class' => 'form-control'],
                                        // Widget template
                                        'template' => '<dt>Ссылка на картинку</dt><dd>{input}{button}</dd>',
                                        // Optional, if set, only this image can be selected by user
                                        'thumb' => 'original',
                                        // Optional, if set, in container will be inserted selected image
                                        'imageContainer' => '.img',
                                        // Default to FileInput::DATA_IDL. This data will be inserted in input field
                                        'pasteData' => FileInput::DATA_URL,
                                        // JavaScript function, which will be called before insert file data to input.
                                        // Argument data contains file data.
                                        // data example: [alt: "Ведьма с кошкой", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
                                        'callbackBeforeInsert' => 'function(e, data) {
                                        console.log( data );
                                    }',
                                    ]);
                                    ?>

                                </dl>

                            </td>

                            <td width="10%"><span class="remove btn btn-danger">Удалить</span></td>
                        </tr>
                    <?php endforeach; endif; ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src="https://code.jquery.com/jquery-3.1.0.js" integrity="sha256-slogkvB1K3VOkzAI8QITxV3VzpOnkeNVsKvtkYLMjfk=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="/scripts/admin/repeatable-fields.js"></script>
<script>
    jQuery('.repeat').each(function() {
        jQuery(this).repeatable_fields(
            {
                move: '.move',
            }
        );
    });
</script>

