<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'msg_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'event')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'event_key')->textInput() ?>

    <?= $form->field($model, 'ticket')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wx_precision')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
