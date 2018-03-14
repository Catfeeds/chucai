<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\GoodImgs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-imgs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'good_id')->textInput() ?>

    <?= $form->field($model, 'img_path')->textInput(['maxlength' => true])->widget('yidashi\webuploader\Cropper',[ 'options'=>['previewWidth'=>200, 'previewHeight'=>100]])  ?>
    <!--

    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>
    -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
