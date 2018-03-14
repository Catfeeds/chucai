<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'is_vest') ?>
    -->
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'phone')->label('手机号') ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'email') ?>
        </div>
    </div>



    <?php // echo $form->field($model, 'head_img') ?>

    <?php // echo $form->field($model, 'passwd') ?>

    <?php // echo $form->field($model, 'pay_passwd') ?>

    <?php // echo $form->field($model, 'real_name') ?>

    <?php // echo $form->field($model, 'card_code') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'use_money') ?>

    <?php // echo $form->field($model, 'cur_bonus') ?>

    <?php // echo $form->field($model, 'freez_money') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'token_time') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn-sm btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn-sm btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
