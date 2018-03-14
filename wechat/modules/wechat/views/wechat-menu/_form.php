<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wechat\modules\wechat\models\WechatMenu;
use wechat\modules\base\models\Lookup;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-menu-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'type')->dropDownList(Lookup::items('wechat-menu-type')) ?>
    <?= $form->field($model, 'pid')->dropDownList(WechatMenu::parents()) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wx_key')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList(Lookup::items('wechat-menu-status')) ?>
    
    <?= $form->field($model, 'sort')->textInput() ?>

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
