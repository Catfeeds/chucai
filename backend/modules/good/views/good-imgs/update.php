<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\GoodImgs */

$this->title = Yii::t('app', 'Update Good Imgs:', [
    'modelClass' => 'Good Imgs',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Good Imgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="good-imgs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
