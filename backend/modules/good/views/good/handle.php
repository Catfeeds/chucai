<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\base\models\Lookup;
/* @var $this yii\web\View */
/* @var $model common\models\Reservation */

$this->title = '操作';
$this->params['breadcrumbs'][] = ['label' => '处理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="doctor-update">

    <h1></h1>

     <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'admin_name')->textInput(['maxlength' => true])->label('审核人') ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true])->label('状态')->dropDownList(['1'=>'审核通过','2'=>'审核失败']) ?>

    <?= $form->field($model, 'admin_remarks')->textarea(['maxlength' => true])->label('备注')  ?>

    <?php if(!$model->isNewRecord){?>

    <?PHP }?>

    <div class="form-group">
        <?= Html::submitButton('处理', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
