<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\sale\models\SaleBanktmp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-banktmp-form">

    <?php $form = ActiveForm::begin(  ['method' => 'post',
//        'action' => \yii\helpers\Url::to(['user/index']), // 默认提交到当前控制器方法,但可以设置
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}<div class='col-lg-5'>{input}</div><div class='col-lg-5'>{hint}{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
//            'hintOptions' => ['class' => 'col-lg-1 '],
        ],
        'id' => 'banktmp-form',
//         'enableAjaxValidation' => true,
        'enableClientValidation' => true,]); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'buit_id')->textInput() ?>

    <?= $form->field($model, 'buyer_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buyer_logon_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recharge_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receipt_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'trade_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'pay_time')->textInput() ?>

    <?= $form->field($model, 'notify_time')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
