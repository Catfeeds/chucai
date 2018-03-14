<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bank\models\CardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--
    <?= $form->field($model, 'id') ?>

     <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'bank_id') ?>
    -->
    <?= $form->field($model, 'card_no') ?>

    <?= $form->field($model, 'card_name') ?>

    <?= $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'province') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'open_bank') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'is_def') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn-sm btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn-sm btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
