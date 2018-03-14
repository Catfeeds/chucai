<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\sale\models\SaleUserpaylog */

$this->title = Yii::t('app', 'Update Sale Userpaylog:', [
    'modelClass' => 'Sale Userpaylog',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sale Userpaylogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sale-userpaylog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
