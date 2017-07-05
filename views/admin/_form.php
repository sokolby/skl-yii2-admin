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

$module = $this->context->module;
$role = $module->model("Role");
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

    <h2>Информация аккаунта:</h2>

    <?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($user, 'receipt_cond_agree')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($user, 'has_sharebonus')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($user, 'newPassword')->passwordInput() ?>

    <?= $form->field($user, 'role_id')->dropDownList($role::dropdown()); ?>

    <?= $form->field($user, 'status')->dropDownList($user::statusDropdown()); ?>

    <?php // use checkbox for banned_at ?>
    <?php // convert `banned_at` to int so that the checkbox gets set properly ?>
    <?php $user->banned_at = $user->banned_at ? 1 : 0 ?>
    <?= Html::activeLabel($user, 'banned_at', ['label' => Yii::t('user', 'Banned')]); ?>
    <?= Html::activeCheckbox($user, 'banned_at'); ?>
    <?= Html::error($user, 'banned_at'); ?>

    <?= $form->field($user, 'banned_reason'); ?>


    <h2>Информация профиля:</h2>

    <?= $form->field($profile, 'surname'); ?>
    <?= $form->field($profile, 'name'); ?>
    <?= $form->field($profile, 'third_name'); ?>
    <?= $form->field($profile, 'sex')->dropDownList([1 => 'Мужской', 0 => 'Женский']); ?>


    <?php
    // Generate data for arrays
    for($i=1;$i<=31;$i++){
        $bday_d_arr[$i] = $i;
    }
    for($i=1932;$i<=2012;$i++){
        $bday_y_arr[$i] = $i;
    }
    $bday_m_arr = [
        "1"=>'Январь',
        "2"=>'Февраль',
        "3"=>'Март',
        "4"=>'Апрель',
        "5"=>'Май',
        "6"=>'Июнь',
        "7"=>'Июль',
        "8"=>'Август',
        "9"=>'Сентябрь',
        "10"=>'Октябрь',
        "11"=>'Ноябрь',
        "12"=>'Декабрь'
    ];
    ?>

    <?= $form->field($profile, 'bday_d')->dropDownList($bday_d_arr,['prompt' => 'День']); ?>
    <?= $form->field($profile, 'bday_m')->dropDownList($bday_m_arr,['prompt' => 'Месяц']); ?>
    <?= $form->field($profile, 'bday_y')->dropDownList($bday_y_arr,['prompt' => 'Год']); ?>

    <?php
    $region_arr = [
        "170"=>'г. Минск',
        "164"=>'Брестская область',
        "165"=>'Витебская область',
        "166"=>'Гомельская область',
        "167"=>'Гродненская область',
        "168"=>'Минская область',
        "169"=>'Могилевская область'
    ];
    $area_type = [
        "186"=>'Город',
        "270"=>'Местечко',
        "267"=>'Микрорайон',
        "259"=>'Поселок городского типа',
        "264"=>'Рабочий поселок',
        "258"=>'Село',
        "254"=>'Станица',
        "277"=>'Аал',
        "291"=>'Автодорога',
        "286"=>'Арбан',
        "257"=>'Аул',
        "284"=>'Выселки(ок)',
        "280"=>'Городок',
        "256"=>'Дачный поселок',
        "263"=>'Деревня',
        "275"=>'ж/д останов. (обгонный) пункт',
        "295"=>'Железнодорожная будка',
        "289"=>'Железнодорожная казарма',
        "293"=>'Железнодорожная платформа',
        "279"=>'Железнодорожная станция',
        "296"=>'Железнодорожный пост',
        "278"=>'Железнодорожный разъезд',
        "300"=>'Жилая зона',
        "287"=>'Жилой район',
        "273"=>'Заимка',
        "266"=>'Казарма',
        "292"=>'Квартал',
        "283"=>'Кордон',
        "281"=>'Курортный поселок',
        "302"=>'Леспромхоз',
        "290"=>'Массив',
        "261"=>'Населенный пункт',
        "274"=>'Остров',
        "299"=>'Планировочный район',
        "297"=>'Погост',
        "253"=>'Поселок',
        "272"=>'Поселок и(при) станция(и)',
        "285"=>'Починок',
        "282"=>'Почтовое отделение',
        "269"=>'Промышленная зона',
        "262"=>'Разъезд',
        "255"=>'Садовое неком-е товарищество',
        "294"=>'Сельская администрация',
        "301"=>'Сельский округ',
        "288"=>'Сельское муниципальное образо',
        "276"=>'Сельское поселение',
        "268"=>'Сельсовет',
        "298"=>'Слобода',
        "265"=>'Станция',
        "260"=>'Территория',
        "271"=>'Улус',
        "252"=>'Хутор',
        "118"=>'Другой тип'
    ];
    ?>

    <?= $form->field($profile, 'region')->dropDownList($region_arr,['prompt' => 'Выберите из списка']); ?>
    <?= $form->field($profile, 'area') ?>
    <?= $form->field($profile, 'area_type')->dropDownList($area_type,['prompt' => 'Выберите из списка']); ?>

    <?= $form->field($profile, 'city') ?>
    <?= $form->field($profile, 'zip') ?>
    <?= $form->field($profile, 'str') ?>

    <?= $form->field($profile, 'house') ?>
    <?= $form->field($profile, 'housing') ?>
    <?= $form->field($profile, 'apt') ?>

    <?= $form->field($profile, 'phone') ?>

    <?= $form->field($profile, 'ava_src') ?>

    <?= $form->field($profile, 'chkbxEmailMe')->checkbox(
        ['label' => '<label for="profile-chkbxemailme">Хочу получать сообщения об акциях "Расшишка"</label>', 'uncheck' => '']); ?>
    <?= $form->field($profile, 'chkbxRules')->checkbox(
        ['label' => '<label for="profile-chkbxrules">Я согласен с условиями <a href="#" class="animate-custom" target="_blank">пользовательского соглашения</a></label>', 'uncheck' => '']); ?>


    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
