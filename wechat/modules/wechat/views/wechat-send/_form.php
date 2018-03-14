<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wechat\modules\base\models\Lookup;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatSend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-send-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'template_id')->dropDownList(Lookup::items('wechat-template-id')) ?>
    
   

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    

    <?= $form->field($model, 'first_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword1_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword1_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword2_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword2_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword3_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword3_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword4_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword4_color')->textInput(['maxlength' => true]) ?>
<!-- 
    <?= $form->field($model, 'keyword5_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword5_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword6_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keyword6_color')->textInput(['maxlength' => true]) ?>
 -->
    <?= $form->field($model, 'remark_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark_color')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
