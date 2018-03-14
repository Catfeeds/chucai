<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatData */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Wechat Data',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wechat-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
