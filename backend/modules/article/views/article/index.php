<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\article\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class= "panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"><i class="fa fa-book"></i><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
        <div id="search" style="display:none"><?php echo $this->render('_search', ['model' => $searchModel]); ?> </div>
        <button class="btn btn-sm btn-info pull-right " id="buttonsearch"><i class="glyphicon glyphicon-search"></i>搜索</button>
        <?= Html::a('<i class="fa fa-remove"></i>'."批量", "javascript:void(0);", ["class" => "btn btn-sm btn-danger gridview pull-right"]) ?>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>'.Yii::t('app', 'Create Article'), ['create'], [
            'class' => 'data-create btn btn-sm btn-success modal-slef pull-left',
        ]) ?>
        <?= Html::a('<i class="fa fa-refresh"></i>'."刷新", "javascript:void(0);", ["class" => "btn btn-sm btn-primary grid-refresh pull-right"]) ?>

        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            "options" => [
                "id" => "grid"
            ],
//        'caption' => '文章管理',
//        'captionOptions' => ['style' => 'font-size: 16px; font-weight: bold; color: #000; text-align: center;'],
//        'filterModel' => $searchModel,
            'columns' => [
                [
                    "class" => "yii\grid\CheckboxColumn",
                    "name" => "id",
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
                ['class' => 'yii\grid\SerialColumn',
                    'header'=>'编号',
                    'headerOptions' => ['width' => '50'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
//            'cid',
                [
                    'label' => '分类名称',
                    'attribute'=>'cid',
                    'headerOptions' => ['width' => '150'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'value' => function ($model) {
                        return \backend\modules\article\models\Category::item($model->cid);
                    },

                ],
//            'id',
//            'title',
                [
                    'attribute' => 'title',
                    'headerOptions' => ['width' => '300'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    "value" => function ($model) {
                        return Html::a($model->title, "/article/article/view?id={$model->id}", ["target" => "_blank"]);
                    },
                    "format" => "raw",

                ],
                [
                    'attribute' => 'auth',
                    'headerOptions' => ['width' => '150'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
                [
                    'attribute' => 'view',
                    'headerOptions' => ['width' => '80'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
                [
                    'attribute' => 'share',
                    'headerOptions' => ['width' => '80'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
//            'view',
//            'share',
//            'abstract',
//            'content:ntext',
//            'auth',
//             'add_time:datetime',
                [
                    'attribute' => 'add_time',
                    'headerOptions' => ['width' => '150'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
                // 'art_img',
                // 'source',
                // 'type',
//             'status',
                [
                    'label' => '状态',
                    'headerOptions' => ['width' => '50'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'value' =>  function ($model){
                        return $model->status == 1 ?'启用':'禁用';
                    },
                ],
                // 'sort',

                // 'chani_url:url',
                // 'con_url:url',

                ['class' => 'yii\grid\ActionColumn',
                    'header'=>'操作',
                    'headerOptions' => ['width' => '300'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'template' => '{view}&nbsp;&nbsp;{auth}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{set}',
                    'buttons' => [
                        'auth' => function ($url, $model, $key) {
                            $btn_str = '开启';
                            if ($model->status == 10)
                            {
                                $btn_str = '关闭';
                                return Html::a($btn_str, $url, [
                                    'class' =>  'btn btn-primary btn-xs fa fa-lock ',
                                    'data' => ['confirm' => '是否修改用户状态？','method'=>'post']
                                ]);
                            }
                            return Html::a($btn_str, $url, [
                                'class' =>  'btn btn-primary btn-xs fa fa-unlock ',
                                'data' => ['confirm' => '是否修改用户状态？','method'=>'post']
                            ]);
                        },
                        'view' => function ($url, $model, $key) {
                            return Html::a('阅读',$url, [
                                'class' => 'data-view btn btn-primary btn-xs fa fa-eye',
                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('修改',$url, [
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
                'options'=>['class' => 'pagination pull-right','style'=> "display:block;"],//关闭自带分页
                'template' => '{pageButtons} {customPage} {pageSize}', //分页栏布局
                'firstPageLabel'=>"首页",
                'prevPageLabel'=>'上一页',
                'nextPageLabel'=>'下一页',
                'lastPageLabel'=>'尾页',
                'pageSizeList' => [5, 10, 15,20], //页大小下拉框值
                'customPageWidth' => 60,            //自定义跳转文本框宽度
                'customPageBefore' => '跳转到第 ',
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
            url   : "/article/article/del",
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

