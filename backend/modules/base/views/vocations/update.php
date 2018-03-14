<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\base\models\Vocations */

$this->title = Yii::t('app', 'Update Vocations:', [
    'modelClass' => 'Vocations',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vocations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->v_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vocations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
