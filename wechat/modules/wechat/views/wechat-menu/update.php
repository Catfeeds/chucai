<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatMenu */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Wechat Menu',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wechat-menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
