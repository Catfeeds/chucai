<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatEvent */

$this->title = Yii::t('app', 'Create Wechat Event');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
