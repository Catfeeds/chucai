<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\base\models\Lookup;
/* @var $this yii\web\View */
/* @var $model common\models\Reservation */

$this->title = '操作';
$this->params['breadcrumbs'][] = ['label' => '处理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="doctor-update">

    <h1></h1>

     <?php $form = ActiveForm::begin(); ?>

    <?php if(!$model->isNewRecord){?>
        <?= $form->field($model, 'pay_username')->label('打款人') ?>
        <?= $form->field($model, 'cash_money')->label('提款金额') ?>
        <?= $form->field($model, 'pay_type')->label('打款方式')->dropDownList(['1'=>'银行卡','2'=>'支付宝']) ?>
        <?= $form->field($model, 'pay_card')->label('打款账号') ?>
        <?= $form->field($model, 'man_remarks')->textarea(['maxlength' => true])->label('管理员备注') ?>
    <?PHP }?>

    <div class="form-group">
        <?= Html::submitButton('处理', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
