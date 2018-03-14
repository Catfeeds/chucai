<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\base\models\LookupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lookup-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'position') ?>
    -->
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'type') ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn-sm btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn-sm btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
