<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\sale\models\SaleGetmoney */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-getmoney-form">

    <?php $form = ActiveForm::begin(
        ['method' => 'post',
//        'action' => \yii\helpers\Url::to(['user/index']), // 默认提交到当前控制器方法,但可以设置
            'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}<div class='col-lg-5'>{input}</div><div class='col-lg-5'>{hint}{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
//            'hintOptions' => ['class' => 'col-lg-1 '],
            ],
            'id' => 'getmoney-form',
//         'enableAjaxValidation' => true,
            'enableClientValidation' => true,]
    ); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cash_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cash_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'case_service_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cash_time')->textInput() ?>

    <?= $form->field($model, 'cash_type')->textInput() ?>

    <?= $form->field($model, 'cash_bank_id')->textInput() ?>

    <?= $form->field($model, 'cash_card')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'success_time')->textInput() ?>

    <?= $form->field($model, 'man_remarks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pay_type')->textInput() ?>

    <?= $form->field($model, 'pay_card')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
