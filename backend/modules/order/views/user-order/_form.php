<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\UserOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_status')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'good_id')->textInput() ?>

    <?= $form->field($model, 'amount_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'u_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'p_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
