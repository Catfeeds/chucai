<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\good\models\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Goods');
$this->params['breadcrumbs'][] = $this->title;
Modal::begin([
    'id' => 'operate-modal',
    'header' => '<h4 class="modal-title"></h4>',
]);
Modal::end();
// 创建
$requestUpdateUrl = Url::toRoute('handle');
$js = <<<JS
// 创建操作
$('.handle').on('click', function () {
    $('.modal-title').html('操作');
    $.get('{$requestUpdateUrl}', { id: $(this).closest('tr').data('key') },
        function (data) {
            $('.modal-body').html(data);
        }  
    );
});
JS;
$this->registerJs($js);
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
        <?= Html::a('<i class="fa fa-reply"></i>'."返回", ['/good/good/index'], ["class" => "btn-sm btn btn-success pull-left"], ['target' => "_self"] ) ?>

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
//            'title',
            [
                'attribute' => 'title',
                'headerOptions' => ['width' => '150'],
            ],
//            'url:url',
            [
                'attribute' => 'url',
                'headerOptions' => ['width' => '200'],
                "value" => function ($model) {
                    return Html::a($model->url,"$model->url",["target" => "_blank"]);
                },
                'format' => 'raw'
            ],
//            'user_id',
            [
                'attribute' => 'user_id',
                'headerOptions' => ['width' => '100'],
                'label'=>'上传者',
                'value' => function ($model) {
                    return \backend\modules\order\models\UserOrder::getUid($model->user_id);
                },
            ],
//            'passwd',
            [
                'attribute' => 'passwd',
                'headerOptions' => ['width' => '100'],
            ],
//             'prize',
            [
                'attribute' => 'prize',
                'headerOptions' => ['width' => '100'],
            ],
//             'prize_youhui',
            [
                'attribute' => 'prize_youhui',
                'headerOptions' => ['width' => '100'],
            ],
            // 'intro',
//             'month_sale_num',
            [
                'attribute' => 'month_sale_num',
                'headerOptions' => ['width' => '100'],
            ],
//             'status',
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '100'],
                'value' => function ($model) {
                    return \backend\modules\base\models\Lookup::item('good-status',$model->status);
                },
                'label'=>'审核状态'
            ],
//             'create_at',
            [
                'attribute' => 'create_at',
                'headerOptions' => ['width' => '200'],
                'label'=>'上传时间'
            ],
            // 'update_at',

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'headerOptions' => ['width' => '250'],
                'template' => '{set}&nbsp;&nbsp;{handle}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                'buttons' => [

//                    'view' => function ($url, $model, $key) {
//                        return Html::a('查看',$url, [
//                            'class' => 'data-view btn btn-primary btn-xs fa fa-eye',
//                        ]);
//                    },
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
                    'set' => function ($url, $model, $key) {
                        return Html::a('图片', ['/good/good-imgs?GoodImgsSearch%5Bgood_id%5D='."$model->id"], [
                            'class' => 'btn btn-info btn-xs fa fa-eye',
                            'target' => "_self",
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'handle' => function ($url, $model, $key) {
                        return Html::a('审核', ['handle','id'=>$key], [
                                'class' => 'btn btn-success btn-xs fa fa-edit handle',
                                'data-toggle' => 'modal', // 固定写法
                                'data-target' => '#operate-modal', // 等于4.1begin中设定的参数id值
                            ]
                        );
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
            url   : "/good/good/del",
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

