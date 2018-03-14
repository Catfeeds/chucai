<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\sale\models\SaleBanktmpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sale Banktmps');
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
        <?= Html::a('<i class="fa fa-reply"></i>'."返回", ['/sale/sale-banktmp/index'], ["class" => "btn-sm btn btn-success pull-left"], ['target' => "_self"] ) ?>
        <!--
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>'.Yii::t('app', 'Create Sale Banktmp'), ['create'], [
            'class' => 'data-create btn btn-sm btn-success modal-slef',
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'data-url' => '/sale/sale-banktmp/create',
            'data-title' => ''
        ]) ?>

        -->
        <?= Html::a('<i class="fa fa-refresh"></i>'."刷新", "javascript:void(0);", ["class" => "btn btn-sm btn-primary grid-refresh pull-right"]) ?>
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
//            'user_id',
//            'order_no',
            [
                'attribute' => 'order_no',
                'headerOptions' => ['width' => '150'],
            ],
//             'subject',
            [
                'attribute' => 'subject',
                'headerOptions' => ['width' => '150'],
                'label'=>'订单标题'
            ],
            [
                'attribute' => 'user_id',
                'headerOptions' => ['width' => '150'],
                'value' => function ($model) {
                    return \backend\modules\order\models\UserOrder::getUid($model->user_id);
                },
                'label'=>'下单用户'
            ],
//            'buit_id',
            [
                'attribute' => 'buit_id',
                'headerOptions' => ['width' => '150'],
                'value' => function ($model) {
                    return \backend\modules\base\models\BaseUseriotype::item($model->buit_id);
                },
                'label'=>'充值交易类型'
            ],
//            'buyer_id',
//            'buyer_logon_id',
//             'recharge_money',
            [
                'attribute' => 'recharge_money',
                'headerOptions' => ['width' => '150'],
                'label'=>'充值金额'
            ],
//             'status',
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '150'],
                'value' => function ($model) {
                    return \backend\modules\base\models\Lookup::item('banktmp-status',$model->status);
                },
                'label'=>'充值状态'
            ],
            // 'service_money',
            // 'receipt_amount',

            // 'trade_no',

            // 'body',
//             'create_time',
            [
                'attribute' => 'create_time',
                'headerOptions' => ['width' => '150'],
            ],
            // 'pay_time',

            // 'notify_time',
            // 'remarks',


            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'headerOptions' => ['width' => '200'],
                'template' => '{view}&nbsp;&nbsp;{delete}',
                'buttons' => [

                    'view' => function ($url, $model, $key) {
                        return Html::a('查看',$url, [
                            'class' => 'data-view btn btn-primary btn-xs fa fa-eye',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('修改','#', [
                            'data-toggle' => 'modal',
                            'data-target' => '#update-modal',
                            'data-id' => $key,
                            'data-url' => $url,
                            'data-title' => '编辑',
                            'class' => 'data-update btn btn-warning btn-xs fa fa-wrench modal-slef',
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
            url   : "/sale/sale-banktmp/del",
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
<?php

Modal::begin([
    'options' => [
        'tabindex' => true
    ],
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title" >操作</h4>',
    'footer' => '<a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>',
]);

$js = <<<JS
$(document).on('click', '.modal-slef', function () {
    aUrl = $(this).attr('data-url');
    aTitle = $(this).attr('data-title');
    $($(this).attr('data-target')+" .modal-title").text(aTitle);
    $.get(aUrl, {},
        function (data) {
            $('#create-modal').find('.modal-body').html(data);
        }

    );
});
JS;
$this->registerJs($js);
Modal::end();
Modal::begin([
    'options' => [
        'tabindex' => true
    ],
    'id' => 'update-modal',
    'header' => '<h4 class="modal-title" >操作</h4>',
    'footer' => '<a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>',
]);

$js = <<<JS
$(document).on('click', '.modal-slef', function () {
    aUrl = $(this).attr('data-url');
    aTitle = $(this).attr('data-title');
    $($(this).attr('data-target')+" .modal-title").text(aTitle);
    $.get(aUrl, {},
        function (data) {
            $('#update-modal').find('.modal-body').html(data);
        }
    );
});
JS;
$this->registerJs($js);
Modal::end();

?>