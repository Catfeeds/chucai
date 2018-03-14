<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use wechat\modules\wechat\models\WechatMenu;
use wechat\modules\base\models\Lookup;

/* @var $this yii\web\View */
/* @var $model wechat\modules\wechat\models\WechatMenu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Wechat Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-menu-view">

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
//             'id',
            'name',
            'type',
            [
                'attribute'=>'pid',
                
                'value' => WechatMenu::parent($model->pid),
            ],
            'url:url',
            'wx_key',
            'sort',
//             'status',
            [
                'attribute'=>'status',
                
                'value' => Lookup::item('wechat-menu-status', $model->status),
            ],
        ],
    ]) ?>

</div>
