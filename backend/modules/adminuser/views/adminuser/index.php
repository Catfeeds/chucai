<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\adminuser\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Adminusers');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class= "panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"><i class="fa fa-user"></i><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">

        <div id="search" style="display:none"><?php echo $this->render('_search', ['model' => $searchModel]); ?> </div>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>'.Yii::t('app', 'Create Adminuser'), ['create'], [
            'class' => 'data-create btn btn-sm btn-success modal-slef',
            'data-toggle' => 'modal',
            'data-target' => '#create-modal',
            'data-url' => '/adminuser/adminuser/create',
            'data-title' => '新增'
        ]) ?>
        <button class="btn btn-sm btn-danger pull-right " id="buttonsearch"><i class="glyphicon glyphicon-search"></i>搜索</button>
        <?= Html::a('<i class="fa fa-refresh"></i>'."刷新", "javascript:void(0);", ["class" => "btn btn-sm btn-primary grid-refresh pull-right"]) ?>
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
//        'rowOptions'=>function($model,$key,$index,$grid) {
//        return ['class' => $index % 2 ==0 ? 'label-red' : 'label-green'];
//        },
//        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
//        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
//        'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header'=>'编号',
                    'contentOptions' => function($model){
                        return ($model -> status == 10) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'headerOptions' =>  ['width' => '50'],
                ],//序列号从1自增长
// 更复杂的列数据
//            [
//                'class' => 'yii\grid\DataColumn', //由于是默认类型，可以省略
//                'value' => function ($data) {
//                    return $data->name;
//                    // 如果是数组数据则为 $data['name'] ，
//                    例如，使用 SqlDataProvider 的情形。
//            },
//            ],

                //'id',
//            'username',
                [
                    'attribute' => 'username',
                    'headerOptions' => ['width' => '120'],
                    'contentOptions' => function($model){
                        return ($model -> status == 10) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
//            [
//                'attribute' => 'username',
//                'value' => function ($model, $key, $index, $column) {
//                    return Html::a($model->username,
//                        ['adminuser/view', 'id' => $key]);
//                },
//                'format' => 'raw',
//            ],
                //'password_hash',
                //'password_reset_token',
                //'auth_key',
                // 'role',

//             'status',
//            [
//                'label' => '操作权限',
//                'value' => function ($model) {
//                    return MenuAuth::item($model->id);
//                }
//            ],
                [
                    'label' => '是否启用',
                    'headerOptions' => ['width' => '120'],
                    'value' =>  function ($model){
                        return $model->status == 10 ?'是':'否';
                    },
                    'contentOptions' => function($model){
                        return ($model -> status == 10) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'filter' => Html::activeDropDownList($searchModel,
                        'status',['10'=>'是','0'=>'否'],
                        ['prompt'=>'全部']
                    )
                ],
//            'email:email',
                [

                    'attribute' => 'email',
                    'headerOptions' => ['width' => '120'],
                    'contentOptions' => function($model){
                        return ($model -> status == 10) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                ],
//             'created_at',
                [

                    'attribute' => 'created_at',
                    'value'=>function($model){
                        return  date('Y-m-d H:i:s',$model->created_at);
                    },
                    'contentOptions' => function($model){
                        return ($model -> status == 10) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'headerOptions' => ['width' => '170'],
                ],
//             'updated_at',


                [
                    'class' => 'yii\grid\ActionColumn',
                    "template" => "{privilege}&nbsp;&nbsp;{auth}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}",
                    "header" => "操作",
                    'contentOptions' => function($model){
                        return ($model -> status == 10) ? ['class' => 'bg-danger'] : ['class' => 'bg-info'];
                    },
                    'headerOptions' => ['width' => '125'],
                    "buttons" => [
                        'privilege'=>function($url,$model,$key)
                        {
                            $options=[
                                'title'=>Yii::t('yii','权限'),
                                'aria-label'=>Yii::t('yii','权限'),
                                'data-pjax'=>'0',
                            ];
                            return Html::a('权限', $url, [
                                'data-toggle' => 'modal',
                                'data-target' => '#privilege-modal',
                                'data-id' => $key,
                                'data-url' => $url,
                                'data-title' => '编辑',
                                'class' => ' btn btn-success btn-xs fa fa-key data-privilege modal-slef',
                                $url,$options]);
                        },
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
                            return Html::a('删除',  $url, [
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
        <?php Pjax::end(); ?>
    </div>
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
Modal::begin([
    'options' => [
        'tabindex' => true
    ],
    'id' => 'privilege-modal',
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
            $('#privilege-modal').find('.modal-body').html(data);
        }
    );
});
JS;
$this->registerJs($js);
Modal::end();

?>

