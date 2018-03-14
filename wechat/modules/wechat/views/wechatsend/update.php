<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatSend */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Wechat Send',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Sends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wechat-send-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
