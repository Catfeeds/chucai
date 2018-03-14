<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
//        'action' => \yii\helpers\Url::to(['user/index']), // 默认提交到当前控制器方法,但可以设置
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}<div class='col-lg-5'>{input}</div><div class='col-lg-5'>{hint}{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
//            'hintOptions' => ['class' => 'col-lg-1 '],
        ],
        'id' => 'category-form',
//         'enableAjaxValidation' => true,
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'pid')->label('文章分类')->dropDownList(\backend\modules\article\models\Category::items()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => '请添加文章分类']) ?>

    <?= $form->field($model, 'sort')->textInput()->label('分类排序') ?>

    <?= $form->field($model, 'position')->label('位置')->radioList(['top'=>'顶部','middle'=>'中间','bottom'=>'底部']) ?>

    <?= $form->field($model, 'status')->label('状态')->radioList(['1'=>'启用','0'=>'禁用']) ?>

    <!--
    <?= $form->field($model, 'model_sn')->textInput() ?>
    -->
    <div>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
