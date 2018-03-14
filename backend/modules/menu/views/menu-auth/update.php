<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\MenuAuth */

$this->title = Yii::t('app', 'Update Menu Auth:', [
    'modelClass' => 'Menu Auth',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu Auths'), 'url' => ['index']];
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
