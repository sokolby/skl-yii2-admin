<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$module = $this->context->module;
$user_model = $module->model("User");
$role_model = $module->model("Role");

$this->title = $orders->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Заказы'), 'url' => ['/user/orders/index']];
$this->params['breadcrumbs'][] = $this->title;

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
        <?= Html::a(Yii::t('user', 'Редактировать'), ['update', 'id' => $orders->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $orders->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Вы уверены что хотите удалить?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $orders,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'format'=>'raw',
                'value' => function ($model) use ($user_model) {
                    $userDropdown = $user_model::findIdentity($model->user_id);

                    if(isset($userDropdown->email)){
                        return "<a href='/user/admin/view?id=".$userDropdown->id."'>".$userDropdown->email."</a> ID=".$userDropdown->id;
                    }else{
                        return '--Ошибка--';
                    }

                }
            ],
            'informed',
            'time',
            [
                'attribute' => 'item',
                'format'=>'raw',
                'value' => function($model) use ($user_model) {

                    $order_cart = json_decode($model->item);
                    $out = "";

                    if($model->type == 'gift'){
                        foreach ($order_cart as $ord){
                            $out .= "Название: {$ord->name} <br/>";
                            $out .= "<br/>";
                        }
                    }else{
                        foreach ($order_cart as $ord){
                            $coll_name = \amnah\yii2\user\models\Magnets::find()->where(['id'=>$ord->collection])->one();
                            $out .= "Коллекция: {$coll_name->title} <br/>";
                            $out .= "Номер магнита: {$ord->number} <br/>";
                            $out .= "<br/>";
                        }
                    }


                    return $out;

                },
            ],
            [
                'attribute' => 'status',
                'format'=>'raw',
                'value' => function($model) {

                    switch ($model->status){
                        case 0:
                            $out = 'Проверяется';
                            break;
                        case 1:
                            $out = '<span style="color: orange">Подтвержден</span>';
                            break;
                        case 2:
                            $out = '<span style="color: green">Отправлен</span>';
                            break;
                    }

                    return $out;

                },
            ]
        ],
    ]) ?>

</div>
