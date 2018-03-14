<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\good\models\GoodCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Good Categories');
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
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>'.Yii::t('app', 'Create Good Category'), ['create'], [
            'class' => 'data-create btn btn-sm btn-success modal-slef',
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'data-url' => '/good/good-category/create',
            'data-title' => ''
        ]) ?>

        <?= Html::a('<i class="fa fa-refresh"></i>'."刷新", "javascript:void(0);", ["class" => "btn btn-sm btn-primary grid-refresh pull-right"]) ?>
        <?= Html::a('<i class="fa fa-reply"></i>'."返回", ['/good/good-category/index'], ["class" => "btn-sm btn btn-success pull-right"], ['target' => "_self"] ) ?>

        <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'header'=>'编号',
                ],

//            'id',
//            'name',
            [
                'attribute' => 'name',
                'headerOptions' => ['width' => '200'],
                'label'=>'分类名称'
            ],
//            'img_path',
//            [
//                'attribute' => 'img_path',
//                'headerOptions' => ['width' => '350'],
//                'label'=>'图片路径'
//            ],
            [
                'label' => '展示图',
                'format' => [
                    'image',
                    [
                        'width'=>'200',
                        'height'=>'100'
                    ]
                ],
                'value' => function ($model) {
                    return 'http://cc2.99caihong.net/uploads/category'."$model->img_path";
                }
            ],
//            'status',
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '200'],
                'value'=>function($model){
                return $model->status == 1?'启用':'禁用';
                },
                'label'=>'状态'
            ],
//            'create_at',
            [
                'attribute' => 'create_at',
                'headerOptions' => ['width' => '300'],
                'label'=>'创建时间'
            ],
            // 'update_at',

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'headerOptions' => ['width' => '250'],
                'template' => '{auth}&nbsp;&nbsp;{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                'buttons' => [
                    'auth' => function ($url, $model, $key) {
                        $btn_str = '启用';
                        if ($model->status == 1)
                        {
                            $btn_str = '禁用';
                            return Html::a($btn_str, $url, [
                                'class' =>  'btn btn-primary btn-xs fa fa-lock ',
                                'data' => ['confirm' => '是否修改状态？','method'=>'post']
                            ]);
                        }
                        return Html::a($btn_str, $url, [
                            'class' =>  'btn btn-primary btn-xs fa fa-unlock',
                            'data' => ['confirm' => '是否修改状态？','method'=>'post']
                        ]);
                    },
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