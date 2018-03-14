<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\UserOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--
    <?= $form->field($model, 'id') ?>

     <?= $form->field($model, 'user_id') ?>

     <?= $form->field($model, 'order_status')->label('订单状态')->dropDownList(\backend\modules\base\models\Lookup::items('order_status'))  ?>

      <?= $form->field($model, 'start_time')->widget(\kartik\datetime\DateTimePicker::classname(), [
        'options' => ['placeholder' => '请选择开始时间'],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
        ],

    ])->label('开始时间'); ?>

    <?= $form->field($model, 'end_time')->widget(\kartik\datetime\DateTimePicker::classname(), [
        'options' => ['placeholder' => '请选择结束时间'],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
        ],

    ])->label('结束时间'); ?>
    -->

    <?= $form->field($model, 'order_code')->label('订单编号') ?>

    <?= $form->field($model, 'name')->label('用户名') ?>

    <?= $form->field($model, 'title')->label('商品标题') ?>



    <?php // echo $form->field($model, 'amount_money') ?>

    <?php // echo $form->field($model, 'u_money') ?>

    <?php // echo $form->field($model, 'p_money') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn-sm btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn-sm btn btn-default']) ?>


    </div>

    <?php ActiveForm::end(); ?>

</div>
