<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\adminuser\models\Adminuser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adminuser-form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
//        'action' => \yii\helpers\Url::to(['user/index']), // 默认提交到当前控制器方法,但可以设置
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}<div class='col-lg-5'>{input}</div><div class='col-lg-5'>{hint}{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
//            'hintOptions' => ['class' => 'col-lg-1 '],
        ],
        'id' => 'adminuser-form',
//         'enableAjaxValidation' => true,
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'placeholder'=>'请输入正确的邮箱地址']) ?>
    <!--
    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'menu_auth_id')->label('账户权限')->dropDownList(\backend\modules\menu\models\MenuAuth::items()) ?>
    -->


    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

