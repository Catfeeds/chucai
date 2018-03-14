<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$model = new \backend\modules\adminuser\models\Adminuser();
$info = $model->find()->where(['id'=>$id])->asArray()->one();
$this->title = '权限设置'."({$info['username']})";
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-privilege">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="adminuser-privilege-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::checkboxList('newPri',$selection,$items)?>

        <div class="form-group">
            <?= Html::submitButton('确认', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
