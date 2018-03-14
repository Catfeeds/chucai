<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\base\models\Lookup;
use backend\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\base\models\ActionLog */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Action Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <!-- 
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
         -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//             'id',
            'name',
            [
                'attribute'=>'type',
                'value' =>  Lookup::item('action-log-type',$model->type),
                
            ],
            [
                'attribute'=>'uid',
                'value' =>  User::item($model->uid),
            
            ],
            
//             'title',
//             'remark',
            [
                'attribute'=>'remark',
                'contentOptions' => ['style' => 'word-break: break-all;white-space: normal;', 'width' => '15%'],
                'value' =>  $model->remark,
            ],
             
//             'status',
            'create_time',
            'model',
            'recorid',
            'action_ip',
        ],
    ]) ?>

</div>
