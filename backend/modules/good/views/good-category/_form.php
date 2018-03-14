<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use budyaga\cropper\Widget;
/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\GoodCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-category-form">

    <?php $form = ActiveForm::begin(
        ['method' => 'post',
//        'action' => \yii\helpers\Url::to(['user/index']), // 默认提交到当前控制器方法,但可以设置
            'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}<div class='col-lg-5'>{input}</div><div class='col-lg-5'>{hint}{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
//            'hintOptions' => ['class' => 'col-lg-1 '],
            ],
            'id' => 'category-form',
//         'enableAjaxValidation' => true,
            'enableClientValidation' => true,]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('分类名称') ?>

    <?= $form->field($model, 'img_path')->textInput(['maxlength' => true])->label('图片路径')->widget('yidashi\webuploader\Cropper',[ 'options'=>['boxId' => 'picker','previewWidth'=>300, 'previewHeight'=>200]])  ?>

    <?= $form->field($model, 'status')->textInput()->label('状态')->dropDownList(['1'=>'启用','0'=>'禁用']) ?>
    <!--
    <?= $form->field($model, 'create_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>
    -->
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
