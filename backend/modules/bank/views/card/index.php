<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bank\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "panel panel-default">
    <div class="panel-heading">

    <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
        <div id="search" style="display:none"><?php echo $this->render('_search', ['model' => $searchModel]); ?> </div>
        <button class="btn btn-sm btn-info pull-right " id="buttonsearch"><i class="glyphicon glyphicon-search"></i>搜索</button>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Html::a('<i class="fa fa-remove"></i>'."批量", "javascript:void(0);", ["class" => "btn btn-sm btn-danger gridview pull-right"]) ?>
        <?= Html::a('<i class="fa fa-refresh"></i>'."刷新", "javascript:void(0);", ["class" => "btn btn-sm btn-primary grid-refresh pull-left"]) ?>
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
                'header'=>'编号'
                ],

//            'id',
//            'user_id',
            [
                'attribute' => 'user_id',
                'headerOptions' => ['width' => '100'],
                'value' => function ($model) {
                    return \backend\modules\order\models\UserOrder::getUid($model->user_id);
                },
                'label'=>'持卡者姓名'
            ],
//            'bank_id',
            [
                'attribute' => 'bank_id',
                'headerOptions' => ['width' => '100'],
                'value' => function ($model) {
                    return \backend\modules\bank\models\Bank::getBank($model->bank_id);
                },
                'label'=>'开户银行'
            ],
//            'card_no',
            [
                'attribute' => 'card_no',
                'headerOptions' => ['width' => '200'],
                'label'=>'卡号'
            ],
//            'card_name',
            [
                'attribute' => 'card_name',
                'headerOptions' => ['width' => '100'],
                'label'=>'账户姓名'
            ],
//             'phone',
            [
                'attribute' => 'phone',
                'headerOptions' => ['width' => '150'],
                'label'=>'绑定手机号'
            ],
//             'province',
            [
                'attribute' => 'province',
                'headerOptions' => ['width' => '100'],
                'label'=>'省份'
            ],
//             'city',
            [
                'attribute' => 'city',
                'headerOptions' => ['width' => '50'],
                'label'=>'市'
            ],
//             'open_bank',
            [
                'attribute' => 'open_bank',
                'headerOptions' => ['width' => '150'],
                'label'=>'开户行'
            ],
            // 'remarks',
//             'status',
            [
                'label' => '银行卡状态',
                'headerOptions' => ['width' => '150'],
                'value' =>  function ($model){
                    return $model->status == 1 ?'启用':'禁用';
                },
            ],
//             'is_def',
            [
                'label' => '是否默认',
                'headerOptions' => ['width' => '150'],
                'value' =>  function ($model){
                    return $model->is_def == 1 ?'默认':'非默认';
                },
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'headerOptions' => ['width' => '250'],
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
$(".gridview").on("click", function () {
    var keys = $("#grid").yiiGridView("getSelectedRows");
    console.log(keys);
    $.ajax({
            type  : "POST",
            url   : "/bank/card/del",
            dataType:"json",
            data:{"id":keys},
           success:function(json) {
                alert("success");
            }

        });
});
');
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