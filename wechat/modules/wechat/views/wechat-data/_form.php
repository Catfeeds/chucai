<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'msg_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'msg_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'pic_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'media_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'format')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recognition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb_media_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location_x')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location_y')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'scale')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
