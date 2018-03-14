<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatData */

$this->title = Yii::t('app', 'Create Wechat Data');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
