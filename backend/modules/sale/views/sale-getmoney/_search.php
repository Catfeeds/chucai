<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\sale\models\SaleGetmoneySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-getmoney-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'cash_money') ?>
    -->

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'cash_no') ?>
        </div>

    </div>
    <?php // echo $form->field($model, 'case_service_money') ?>

    <?php // echo $form->field($model, 'cash_time') ?>

    <?php // echo $form->field($model, 'cash_type') ?>

    <?php // echo $form->field($model, 'cash_bank_id') ?>

    <?php // echo $form->field($model, 'cash_card') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'success_no') ?>

    <?php // echo $form->field($model, 'success_money') ?>

    <?php // echo $form->field($model, 'success_service_money') ?>

    <?php // echo $form->field($model, 'success_time') ?>

    <?php // echo $form->field($model, 'rec') ?>

    <?php // echo $form->field($model, 'reccode') ?>

    <?php // echo $form->field($model, 'rec_monry') ?>

    <?php // echo $form->field($model, 'rec_time') ?>

    <?php // echo $form->field($model, 'rec_member') ?>

    <?php // echo $form->field($model, 'user_remarks') ?>

    <?php // echo $form->field($model, 'man_remarks') ?>

    <?php // echo $form->field($model, 'review_status') ?>

    <?php // echo $form->field($model, 'cash_out') ?>

    <?php // echo $form->field($model, 'pay_username') ?>

    <?php // echo $form->field($model, 'pay_type') ?>

    <?php // echo $form->field($model, 'pay_card') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn-sm btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn-sm btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
