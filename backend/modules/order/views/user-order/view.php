<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\UserOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "panel panel-default">
    <div class="panel-heading">

    <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
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
//            'order_code',
            [
                'attribute' => 'order_code',
                'label'=>'订单编号'
            ],
//            'order_status',
            [
                'attribute' => 'order_status',
                'value' => function ($model) {
                    return \backend\modules\base\models\Lookup::item('order_status',$model->order_status);
                },
                'label'=>'支付状态'
            ],
//            'user_id',
//            'good_id',
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return \backend\modules\order\models\UserOrder::getUid($model->user_id);
                },
                'label'=>'下单用户'
            ],
//            'good_id',
            [
                'attribute' => 'good_id',
                'value' => function ($model) {
                    return \backend\modules\good\models\Good::getUid($model->good_id);
                },
                'label'=>'商品标题'
            ],
            'amount_money',
            'u_money',
            'p_money',
//            'create_at',
            [
                'attribute' => 'create_at',
                'label'=>'下单时间'
            ],
//            'update_at',
            [
                'attribute' => 'create_at',
                'label'=>'更新时间'
            ],
        ],
    ]) ?>

</div>
</div>