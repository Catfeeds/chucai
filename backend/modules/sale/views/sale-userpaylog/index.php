<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\sale\models\SaleUserpaylogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sale Userpaylogs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "panel panel-default">
    <div class="panel-heading">

    <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="search" style="display:none"><?php echo $this->render('_search', ['model' => $searchModel]); ?> </div>
        <button class="btn btn-sm btn-info pull-right " id="buttonsearch"><i class="glyphicon glyphicon-search"></i>搜索</button>
        <?= Html::a('<i class="fa fa-remove"></i>'."批量", "javascript:void(0);", ["class" => "btn btn-sm btn-danger gridview pull-right"]) ?>
        <?= Html::a('<i class="fa fa-refresh"></i>'."刷新", "javascript:void(0);", ["class" => "btn btn-sm btn-primary grid-refresh pull-right"]) ?>
        <?= Html::a('<i class="fa fa-reply"></i>'."返回", ['/sale/sale-userpaylog/index'], ["class" => "btn-sm btn btn-success pull-left"], ['target' => "_self"] ) ?>


        <p>
        <!--
        <?= Html::a(Yii::t('app', 'Create Sale Userpaylog'), ['create'], ['class' => 'btn btn-success']) ?>
        -->
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
            "options" => [
                "id" => "grid"
            ],
//        'filterModel' => $searchModel,
        'columns' => [
            [
                "class" => "yii\grid\CheckboxColumn",
                "name" => "id",

            ],
            ['class' => 'yii\grid\SerialColumn',
                'header'=>'编号',
                ],

//            'id',
            // 'order_id',
            [
                'attribute' => 'order_id',
                'headerOptions' => ['width' => '300'],
                'label'=>'订单号',
            ],
//            'type',
            [
                'attribute' => 'type',
                'headerOptions' => ['width' => '200'],
                'label'=>'进出账',
                'value' => function($model){
                    return ($model -> type == 1) ? '出账' :'进账';
                },
            ],

//            'busisort',
//            'busino',
//            'pay_make_id',
            // 'user_id',
            // 'user_name',
            [
                'attribute' => 'user_name',
                'headerOptions' => ['width' => '200'],
                'label'=>'用户名',
            ],

            // 'pay_money',
            [
                'attribute' => 'pay_money',
                'headerOptions' => ['width' => '200'],
                'label'=>'订单金额',
            ],
            [
                'attribute' => 'pay_poundage',
                'headerOptions' => ['width' => '200'],
                'label'=>'订单手续费',
            ],
//            [
//                'attribute' => 'has_pay',
//                'headerOptions' => ['width' => '200'],
//                'label'=>'账户余额',
//            ],
            // 'status',
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '200'],
                'label'=>'状态',
                'value' => function($model){
                    return ($model -> status == 1) ? '已成功' :'未成功';
                },
            ],
            // 'pay_poundage',
            // 'has_pay',
//             'add_time',
            [
                'attribute' => 'add_time',
                'headerOptions' => ['width' => '200'],
                'label'=>'创建时间',

            ],
            // 'remarks',
            // 'admin_remarks',
            // 'admin_name',


            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'headerOptions' => ['width' => '200'],
                'template' => '{view}&nbsp;&nbsp;{delete}&nbsp;&nbsp;',
                'buttons' => [

                    'view' => function ($url, $model, $key) {
                        return Html::a('查看',$url, [
                            'class' => 'data-view btn btn-primary btn-xs fa fa-eye',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('删除', $url,  [
                            'class' => 'btn btn-danger btn-xs fa fa-trash-o',
                            'data' => ['confirm' => '删除该条记录,是否继续操作？','method'=>'post']
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
$(".gridview").on("click", function () {
    var keys = $("#grid").yiiGridView("getSelectedRows");
    console.log(keys);
    $.ajax({
            type  : "POST",
            url   : "/sale/sale-userpaylog/del",
            dataType:"json",
            data:{"id":keys},
           success:function(json) {
                alert("success");
            }

        });
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