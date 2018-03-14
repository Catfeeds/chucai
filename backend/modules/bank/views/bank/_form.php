<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bank\models\Bank */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput()->label('状态')->dropDownList(['1'=>'启用','0'=>'禁用']) ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => true])->label('logo')->widget('yidashi\webuploader\Cropper',[ 'options'=>['previewWidth'=>300, 'previewHeight'=>200]])  ?>

    <?= $form->field($model, 'rgb')->widget(alexantr\colorpicker\ColorPicker::className()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
