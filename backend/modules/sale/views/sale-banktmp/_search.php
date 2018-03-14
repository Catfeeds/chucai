<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\sale\models\SaleBanktmpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-banktmp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'buit_id') ?>

    <?= $form->field($model, 'buyer_id') ?>

     <?= $form->field($model, 'buyer_logon_id') ?>
    -->
<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'order_no') ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'name')->label('用户名') ?>
    </div>
</div>
    <?php // echo $form->field($model, 'recharge_money') ?>

    <?php // echo $form->field($model, 'service_money') ?>

    <?php // echo $form->field($model, 'receipt_amount') ?>

    <?php // echo $form->field($model, 'order_no') ?>

    <?php // echo $form->field($model, 'trade_no') ?>

    <?php // echo $form->field($model, 'subject') ?>

    <?php // echo $form->field($model, 'body') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'pay_time') ?>

    <?php // echo $form->field($model, 'notify_time') ?>

    <?php // echo $form->field($model, 'abbpay_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'post') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn-sm btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn-sm btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
