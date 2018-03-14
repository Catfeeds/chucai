<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\base\models\Lookup */

$this->title = Yii::t('app', 'Update Lookup:', [
    'modelClass' => 'Lookup',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lookups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
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
