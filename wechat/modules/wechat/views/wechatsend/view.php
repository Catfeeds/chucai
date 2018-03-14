<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatSend */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Sends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-send-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'template_id',
            'first_value',
            'first_color',
            'keyword1_value',
            'keyword1_color',
            'keyword2_value',
            'keyword2_color',
            'keyword3_value',
            'keyword3_color',
            'keyword4_value',
            'keyword4_color',
            'keyword5_value',
            'keyword5_color',
            'keyword6_value',
            'keyword6_color',
            'remark_value',
            'remark_color',
        ],
    ]) ?>

</div>
