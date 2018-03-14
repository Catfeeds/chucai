<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\order\models\UserOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "panel panel-default">
    <div class="panel-heading">
    <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
        <div id="search" style="display:none"><?php echo $this->render('_search', ['model' => $searchModel]); ?> </div>
        <button class="btn btn-sm btn-danger pull-right " id="buttonsearch"><i class="glyphicon glyphicon-search"></i>搜索</button>
        <?= Html::a('<i class="fa fa-refresh"></i>'."刷新", "javascript:void(0);", ["class" => "btn btn-sm btn-primary grid-refresh pull-right"]) ?>
        <?= Html::a('<i class="fa fa-reply"></i>'."返回", ['/order/user-order/index'] , ["class" => "btn-sm btn btn-success pull-left"], ['target' => "_self"]) ?>

        <!--
        <?= Html::a(Yii::t('app', 'Create User Order'), ['create'], ['class' => 'btn btn-success']) ?>
-->

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn',
//                'header'=>'编号',
//                ],

//            'id',
            [
                'attribute' => 'id',
                'headerOptions' => ['width' => '50'],
            ],
//            'order_code',
            [
                'attribute' => 'order_code',
                'headerOptions' => ['width' => '200'],
                'label'=>'订单编号'
            ],
//            'order_status',

//            'user_id',
            [
                'attribute' => 'user_id',
                'headerOptions' => ['width' => '150'],
                'value' => function ($model) {
                    return \backend\modules\order\models\UserOrder::getUid($model->user_id);
                },
                'label'=>'下单用户'
            ],
//            'good_id',
            [
                'attribute' => 'good_id',
                'headerOptions' => ['width' => '200'],
                'value' => function ($model) {
                    return \backend\modules\good\models\Good::getUid($model->good_id);
                },
                'label'=>'商品标题'
            ],
//             'amount_money',
            [
                'attribute' => 'amount_money',
                'headerOptions' => ['width' => '100'],
            ],
            [
                'attribute' => 'order_status',
                'headerOptions' => ['width' => '150'],
                'value' => function ($model) {
                    return \backend\modules\base\models\Lookup::item('order_status',$model->order_status);
                },
                'label'=>'支付状态'
            ],
            // 'u_money',
            // 'p_money',
            // 'create_at',
            [
                'attribute' => 'create_at',
                'headerOptions' => ['width' => '150'],
                'label'=>'下单时间'
            ],
            // 'update_at',

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'headerOptions' => ['width' => '100'],
                'template' => '{view}&nbsp;&nbsp;',
                'buttons' => [

                    'view' => function ($url, $model, $key) {
                        return Html::a('查看',$url, [
                            'class' => 'data-view btn btn-primary btn-xs fa fa-eye',
                        ]);
                    },
                ],
            ],
        ],
            'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            'pager' => [
                'class' => \common\widgets\LinkPager::className(),
                'options'=>['class' => 'pagination','style'=> "display:block;pull-right"],//关闭自带分页
                'template' => '{pageButtons} {customPage} {pageSize}', //分页栏布局
                'firstPageLabel'=>"首页",
                'prevPageLabel'=>'上一页',
                'nextPageLabel'=>'下一页',
                'lastPageLabel'=>'尾页',
                'pageSizeList' => [5, 10, 15,20], //页大小下拉框值
                'customPageWidth' => 60,            //自定义跳转文本框宽度
                'customPageBefore' => '  跳转到第 ',
                'customPageAfter' => ' 页 每页行数 ',
            ],
        ]);
        $this->registerJs('
$("#buttonsearch").on("click", function () {
  if($("#search").css("display")=="none"){
				$("#search").css("display","block");
			}else{
				$("#search").css("display","none");
			}
});
');
            $this->registerJs('
$(".grid-refresh").on("click", function () {
   window.location.reload()
});
');
?>
<?php Pjax::end(); ?></div>
</div>