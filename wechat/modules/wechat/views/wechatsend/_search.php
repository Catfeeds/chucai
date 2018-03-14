<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatSendSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-send-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'template_id') ?>

    <?= $form->field($model, 'first_value') ?>

    <?php // echo $form->field($model, 'first_color') ?>

    <?php // echo $form->field($model, 'keyword1_value') ?>

    <?php // echo $form->field($model, 'keyword1_color') ?>

    <?php // echo $form->field($model, 'keyword2_value') ?>

    <?php // echo $form->field($model, 'keyword2_color') ?>

    <?php // echo $form->field($model, 'keyword3_value') ?>

    <?php // echo $form->field($model, 'keyword3_color') ?>

    <?php // echo $form->field($model, 'keyword4_value') ?>

    <?php // echo $form->field($model, 'keyword4_color') ?>

    <?php // echo $form->field($model, 'keyword5_value') ?>

    <?php // echo $form->field($model, 'keyword5_color') ?>

    <?php // echo $form->field($model, 'keyword6_value') ?>

    <?php // echo $form->field($model, 'keyword6_color') ?>

    <?php // echo $form->field($model, 'remark_value') ?>

    <?php // echo $form->field($model, 'remark_color') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
