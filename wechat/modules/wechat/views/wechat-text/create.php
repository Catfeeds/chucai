<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatText */

$this->title = Yii::t('app', 'Create Wechat Text');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Texts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
