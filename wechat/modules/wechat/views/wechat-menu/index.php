<?php

use yii\helpers\Html;
use yii\grid\GridView;
use wechat\modules\base\models\Lookup;
use wechat\modules\wechat\models\WechatMenu;

/* @var $this yii\web\View */
/* @var $searchModel wechat\modules\wechat\models\WechatMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Wechat Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Wechat Menu'), ['create'], ['class' => 'btn btn-success']) ?>
        <!-- 
         <?= Html::a(Yii::t('app', 'Publish'), ['publish'], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to publish this item?'),
                'method' => 'post',
            ],
        ]) ?>
         -->
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//             ['class' => 'yii\grid\SerialColumn'],

//             'id',
            
            'name',
            'type',
//             'pid',
            [
                'attribute'=>'pid',
                'value' => function ($model) {
                    return WechatMenu::parent($model->pid);
                },
                //在搜索条件（过滤条件）中使用下拉框来搜索
                'filter' => Html::activeDropDownList($searchModel,
                    'status',WechatMenu::parents(),
                    ['prompt'=>'全部']
                )
            ],
            
            'url:url',
            'wx_key',
            'sort',
            [
                'attribute'=>'status',
                'value' => function ($model) {
                    return Lookup::item('wechat-menu-status', $model->status);
                },
                //在搜索条件（过滤条件）中使用下拉框来搜索
                'filter' => Html::activeDropDownList($searchModel,
                    'status',Lookup::items('wechat-menu-status'),
                    ['prompt'=>'全部']
                )
            ],
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
