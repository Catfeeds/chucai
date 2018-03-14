<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\UserOrder */

$this->title = Yii::t('app', 'Update User Order:', [
    'modelClass' => 'User Order',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class= "panel panel-default">
    <div class="panel-heading">

    <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
