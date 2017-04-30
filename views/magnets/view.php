<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$this->title = $magnets->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Коллекция'), 'url' => ['/user/magnets/index']];
$this->params['breadcrumbs'][] = $this->title;

$module = $this->context->module;
$prod_cat = $module->model("ProdCat");
?>
<style>
    table.detail-view th {
        width: 25%;
    }

    table.detail-view td {
        width: 75%;
    }
</style>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('user', 'Редактировать'), ['update', 'id' => $magnets->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $magnets->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Вы уверены что хотите удалить?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $magnets,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'grid',
                'label' => 'Размер сетки',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div>'.$model->grid_x.' x '.$model->grid_y.'</div>';
                },
            ],
            'grid_x',
            'grid_y',

            [
                'attribute' => 'grid',
                'label' => 'Размер магнита',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div>'.$model->size_x.' x '.$model->size_y.'</div>';
                },
            ],
            'size_x',
            'size_y',
            [
                'attribute' => 'items',
                'format'=>'raw',
                'value' => function ($model) {
                    if(isset($model->items)){
                        $items = json_decode($model->items);
                    }
                    $ret = "";

                    if(isset($items[0])){
                        foreach ($items as $item) {

                            $ret .= "Номер: {$item->number} <br/> 
                                 Ссылка на картинку: {$item->image} <br/> 
                                 <hr/>
                                 ";
                        }
                    }

                    return $ret;
                }
            ],

        ],
    ]) ?>

</div>
