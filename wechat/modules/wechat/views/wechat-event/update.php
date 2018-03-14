<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatEvent */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Wechat Event',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wechat-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
