<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--
    <?= $form->field($model, 'id') ?>

     <?= $form->field($model, 'abstract') ?>

    <?= $form->field($model, 'content') ?>
    -->
    <div class="row">
    <div class="col-md-4">
    <?= $form->field($model, 'cid')->label('文章分类')->dropDownList(\backend\modules\article\models\Article::items()) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'title') ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'auth') ?>
    </div>
</div>
    <?php // echo $form->field($model, 'add_time') ?>

    <?php // echo $form->field($model, 'view') ?>

    <?php // echo $form->field($model, 'share') ?>

    <?php // echo $form->field($model, 'art_img') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'cid') ?>

    <?php // echo $form->field($model, 'chani_url') ?>

    <?php // echo $form->field($model, 'con_url') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-sm btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
