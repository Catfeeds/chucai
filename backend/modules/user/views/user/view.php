<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\user\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "panel panel-default">
    <div class="panel-heading">

    <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'phone',
            [
                'attribute' => 'phone',
                'headerOptions' => ['width' => '150'],
                'label'=>'手机号'
            ],
            'name',
            'email:email',
//            'is_vest',
            [
                'attribute' => 'is_vest',
                'headerOptions' => ['width' => '150'],
                'value' => function($model){
                    return ($model -> is_vest == 1) ? '内部用户' :'普通用户';
                },
                'label'=>'用户类型'
            ],
            'head_img',
            'passwd',
            'pay_passwd',
            'real_name',
            'card_code',
//            'type',
//            'status',
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '150'],
                'value' => function ($model) {
                    return \backend\modules\base\models\Lookup::item('status',$model->status);
                },
                'label'=>'用户状态'
            ],
            'use_money',
            'cur_bonus',
            'freez_money',
//            'token',
//            'token_time',
//            'create_at',
            [
                'attribute' => 'create_at',
                'headerOptions' => ['width' => '150'],
                'label'=>'注册时间'
            ],
            'update_at',
        ],
    ]) ?>

</div>
</div>