<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\web\JsExpression;
use pendalf89\filemanager\widgets\FileInput;
use app\modules\yii2extensions\models\Image;
use wbraganca\dynamicform\DynamicFormWidget;
?>

    <div id="panel-option-values" class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"> Магниты</h3>
        </div>

        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.form-options-body',
            'widgetItem' => '.form-options-item',
            'min' => 1,
            'insertButton' => '.add-item',
            'deleteButton' => '.delete-item',
            'model' => $modelsOptionValue[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'number',
                'image'
            ],
        ]); ?>

        <table class="table table-bordered table-striped margin-b-none">
            <thead>
            <tr>
                <th style="width: 10%; text-align: center"></th>
                <th style="width: 40%" class="required">Номер</th>
                <th style="width: 40%">Картинка</th>
                <th style="width: 10%; text-align: center"></th>
            </tr>
            </thead>
            <tbody class="form-options-body">
            <?php foreach ($modelsOptionValue as $index => $modelOptionValue): ?>
                <tr class="form-options-item">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;vertical-align: middle;">
                        <i class="glyphicon glyphicon-resize-vertical"></i>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelOptionValue, "[{$index}]number")->label(false)->textInput(['maxlength' => 128]); ?>
                    </td>
                    <td>

                        <?=
                        $form->field($modelOptionValue, "[{$index}]image")->widget(FileInput::className(), [
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
                        ]);
                        ?>

                    </td>
                    <td class="text-center vcenter" style="vertical-align: middle;">
                        <button type="button" class="delete-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3"></td>
                <td><button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> New</button></td>
            </tr>
            </tfoot>
        </table>
        <?php DynamicFormWidget::end(); ?>
    </div>

<?php
$js = <<<'EOD'

$(".optionvalue-img").on("filecleared", function(event) {
    var regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    var id = event.target.id;
    var matches = id.match(regexID);
    if (matches && matches.length === 4) {
        var identifiers = matches[2].split("-");
        $("#optionvalue-" + identifiers[1] + "-deleteimg").val("1");
    }
});

var fixHelperSortable = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};

$(".form-options-body").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
    helper: fixHelperSortable,
    update: function(ev){
        $(".dynamicform_wrapper").yiiDynamicForm("updateContainer");
    }
}).disableSelection();

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>