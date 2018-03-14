<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\base\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-striped table-bordered">
        <th ><td>注册量</td><td>访问量</td></th>
        <tr ><td>PV统计</td><td><?=Html::encode($model["pv_count"])?></td><td><?=Html::encode($model["pv"])?></td></tr>
        <tr><td>UV统计</td><td><?=Html::encode($model["pv_count"])?></td><td><?=Html::encode($model["uv"])?></td></tr>

    </table>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'编号'],

//            'id',
            'userphone',
            'ip',
            'count',
//            'platform',
            'create_time',



        ],
        'pager' => [
            'firstPageLabel' => "首页",
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'lastPageLabel' => '最后一页',
        ],
    ]); ?>

</div>
