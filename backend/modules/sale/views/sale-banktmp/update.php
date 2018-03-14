<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\sale\models\SaleBanktmp */

$this->title = Yii::t('app', 'Update Sale Banktmp:', [
    'modelClass' => 'Sale Banktmp',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sale Banktmps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sale-banktmp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
