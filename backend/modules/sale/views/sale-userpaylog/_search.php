<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\sale\models\SaleUserpaylogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-userpaylog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'busisort') ?>

    <?= $form->field($model, 'busino') ?>

    <?= $form->field($model, 'pay_make_id') ?>
    -->

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'order_id') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'user_name') ?>
        </div>

    </div>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'user_name') ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo $form->field($model, 'pay_money') ?>

    <?php // echo $form->field($model, 'pay_poundage') ?>

    <?php // echo $form->field($model, 'has_pay') ?>

    <?php // echo $form->field($model, 'add_time') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'admin_remarks') ?>

    <?php // echo $form->field($model, 'admin_name') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn-sm btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn-sm btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
