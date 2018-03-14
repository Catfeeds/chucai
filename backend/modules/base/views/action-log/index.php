<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\user\models\User;
use backend\modules\base\models\Lookup;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\base\models\ActionLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Action Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<!--
    <p>
        <?= Html::a(Yii::t('app', 'Create Action Log'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
      -->
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

//             'id',
            'create_time',
//             'type',
            [
                'attribute'=>'type',
                'value' => function ($model) {
                    return Lookup::item('action-log-type',$model->type);
                },
                //在搜索条件（过滤条件）中使用下拉框来搜索
                'filter' => Html::activeDropDownList($searchModel,
                    'type',Lookup::items('action-log-type'),
                    ['prompt'=>'全部']
                )
            ],
            
            'name',
            [
                'attribute'=>'remark',
                'contentOptions' => ['style' => 'word-break: break-all;white-space: normal;', 'width' => '15%'],
                'value' => function ($model) {
                    return $model->remark;
                },
            ],
            
            [
                'attribute'=>'uid',
                'value' => function ($model) {
                    return User::item($model->uid);
                },
                //在搜索条件（过滤条件）中使用下拉框来搜索
                'filter' => Html::activeDropDownList($searchModel,
                    'uid',User::items(true),
                    ['prompt'=>'全部']
                )
            ],
            
            'action_ip',
//             'title',
//             'status',
            
            // 'model',
            // 'recorid',

            [
                'class' => 'yii\grid\ActionColumn',
                "template" => "{view}",
                'header'=> '操作',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
