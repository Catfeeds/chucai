<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatText */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Wechat Text',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Texts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wechat-text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
