<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$this->title = $product->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Продукты'), 'url' => ['/user/product/index']];
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
        <?= Html::a(Yii::t('user', 'Редактировать'), ['update', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $product->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Вы уверены что хотите удалить?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $product,
        'attributes' => [
            'id',
            'position',
            'title',
            'desc',
            'consist',
            [
                'attribute' => 'items',
                'format'=>'raw',
                'value' => function ($model) {
                    if(isset($model->items)){
                        $items = json_decode($model->items);
                    }
                    $ret = "";

                    foreach ($items as $item){

                        if(isset($item->promo_on) AND $item->promo_on == 'on'){
                            $promo_on_ret = 'Да';
                        }else{
                            $promo_on_ret = 'Нет';
                        }
                        $ret .= "Формат: {$item->form} <br/> 
                                 Награда: {$item->reward} <br/> 
                                 Ссылка на картинку: {$item->image} <br/> 
                                 Участвует в акции: {$promo_on_ret} <br/> 
                                 <hr/>
                                 ";
                    }

                    return $ret;
                }
            ],
            [
                'attribute' => 'category_id',
                'format'=>'raw',
                'value' => function ($model) use ($prod_cat) {
                    $prodCatDropdown = $prod_cat::dropdown();
                    if(isset($prodCatDropdown[$model->category_id])){
                        return '<a href="/user/product_cat/view?id='.$model->category_id.'">'.$prodCatDropdown[$model->category_id].'</a>';
                    }else{
                        return '--Категория не найдена--';
                    }

                }
            ],

        ],
    ]) ?>

</div>
