<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'msg_type') ?>

    <?= $form->field($model, 'to_user_name') ?>

    <?= $form->field($model, 'from_user_name') ?>

    <?= $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'msg_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'pic_url') ?>

    <?php // echo $form->field($model, 'media_id') ?>

    <?php // echo $form->field($model, 'format') ?>

    <?php // echo $form->field($model, 'recognition') ?>

    <?php // echo $form->field($model, 'thumb_media_id') ?>

    <?php // echo $form->field($model, 'location_x') ?>

    <?php // echo $form->field($model, 'location_y') ?>

    <?php // echo $form->field($model, 'scale') ?>

    <?php // echo $form->field($model, 'label') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'url') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
