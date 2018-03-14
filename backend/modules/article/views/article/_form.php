<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'cid')->label('文章分类')->dropDownList(\backend\modules\article\models\Article::items()) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'placeholder' => '请添加文章标题']) ?>

    <?= $form->field($model, 'abstract')->textInput(['maxlength' => true,'placeholder' => '请输入文章摘要']) ?>

    <?= $form->field($model, 'auth')->textInput(['maxlength' => true,'placeholder' => '请输入作者']) ?>

    <?= $form->field($model, 'art_img')->label('文章缩略图')->widget('yidashi\webuploader\Cropper',[ 'options'=>['previewWidth'=>200, 'previewHeight'=>100]]) ?>

    <?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor',['clientOptions' => [
        'initialFrameWidth' => "100%",]]) ?>
    <!--
    <?= $form->field($model, 'add_time')->textInput() ?>

    <?= $form->field($model, 'view')->textInput() ?>

    <?= $form->field($model, 'source')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'chani_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'con_url')->textInput(['maxlength' => true]) ?>
    -->
    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'share')->label('是否可分享')->radioList(['1'=>'是','0'=>'否']) ?>

    <?= $form->field($model, 'status')->label('状态')->radioList(['1'=>'启用','0'=>'禁用']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
