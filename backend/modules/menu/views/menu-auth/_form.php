<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\menu\models\Menu;

/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\MenuAuth */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-auth-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'boxlist')->checkboxList(Menu::items(0,true)) ?>
<!-- 
    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>
 -->
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
