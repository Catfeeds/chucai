<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\article\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"><i class="fa fa-sitemap"></i><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>'.Yii::t('app', 'Create Category'), ['create'], [
                'class' => 'data-create btn btn-sm btn-success modal-slef',
                'data-toggle' => 'modal',
                'data-target' => '#create-modal',
                'data-url' => '/article/category/create',
                'data-title' => ''
            ]) ?>

        <?= Html::a('<i class="fa fa-refresh"></i>'."刷新", "javascript:void(0);", ["class" => "btn btn-sm btn-primary grid-refresh pull-right"]) ?>

        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,

//        'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn',
                    'header'=>'编号',
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],

//            'id',
//            'name',
                [
                    'label' => '分类名称',
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'attribute'=>'name',
                    'headerOptions' => ['width' => '300'],
                    'value' => function ($model) {
                        if($model->pid == 0){
                            return $model->name;
                        }else{
                            return '├─ '."$model->name";
                        }
                    },
                ],
//            'position',
                [
                    'label' => '显示位置',
                    'attribute'=>'position',
                    'headerOptions' => ['width' => '200'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'value' => function ($model) {
                        return \backend\modules\base\models\Lookup::item('position', $model->position);
                    },
                ],
//            'model_sn',
//            'sort',
                [
                    'attribute' => 'sort',
                    'headerOptions' => ['width' => '200'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
//            'status',
                [
                    'label' => '状态',
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'headerOptions' => ['width' => '200'],
                    'value' =>  function ($model){
                        return $model->status == 1 ? '启用':'禁用';
                    },
                ],

//            'pid',


                ['class' => 'yii\grid\ActionColumn',
                    'header'=>'操作',
                    'headerOptions' => ['width' => '300'],
                    'contentOptions' => function($model){
                        return ($model -> status == 1) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'template' => '{auth}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{set}',
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

                            $htmlstr = '<div class="btn-group">
                              <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>新增 
                              </button>
                              <ul class="dropdown-menu">';

                            if (in_array($model->pid,[0])) {
                                $htmlstr .= '<li>' . Html::a('新增下级', ['new', 'id' => $model->id], [
                                        'target' => "_self",
                                        'data' => [
                                            'method' => 'post',
                                        ],
//                                    'data-toggle' => 'modal',
//                                    'data-target' => '#new-modal',
//                                    'data-id' => $model->id,
//                                    'data-url' => $url,
//                                    'data-title' => '编辑',
//                                    'class' => 'data-new btn btn-warning btn-xs fa fa-plus modal-slef',
                                    ]) . '</li>';
                            }
                            if ($model->pid != 0) {
                                $htmlstr .= '<li>' . Html::a('新增文章', ['article/article', 'id' => $model->id], [
                                        'target' => "_self",
                                        'data' => [
                                            'method' => 'post',
                                        ],
//                                    'data-toggle' => 'modal',
//                                    'data-target' => '#new-modal',
//                                    'data-id' => $model->id,
//                                    'data-url' => $url,
//                                    'data-title' => '编辑',
//                                    'class' => 'data-new btn btn-warning btn-xs fa fa-plus modal-slef',
                                    ]) . '</li>';
                            }
//                        if ($model->pid != 0) {
//                            $htmlstr .= '<li>' . Html::a('新增文章', ['update', 'id' => $key], [
//                                    'target' => "_self",
//                                    'data' => [
//                                        'method' => 'post',
//                                    ],
//                                ]) . '</li>';
//                        }
                            $htmlstr .='</ul>'.
                                '</div>';

                            return $htmlstr;
                        },
                    ],
                ],
            ],
            'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            'pager' => [
                'class' => \common\widgets\LinkPager::className(),
                'options'=>['class' => 'pagination','style'=> "display:block;pull-right"],//关闭自带分页
                'template' => '{pageButtons}{customPage} {pageSize} ', //分页栏布局
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

