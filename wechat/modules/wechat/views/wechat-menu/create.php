<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatMenu */

$this->title = Yii::t('app', 'Create Wechat Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
