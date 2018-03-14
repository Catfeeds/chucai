<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatSend */

$this->title = Yii::t('app', 'Create Wechat Send');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Sends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-send-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
