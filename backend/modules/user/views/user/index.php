<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
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
        <?= Html::a('<i class="fa fa-reply"></i>'."返回", ['/user/user/index'] , ["class" => "btn-sm btn btn-success pull-left"], ['target' => "_self"]) ?>
    <p>
        <!--
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
        -->
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'header'=>'编号',
            ],

//            'id',
//            'phone',
            [
                'attribute' => 'phone',
                'headerOptions' => ['width' => '150'],
                'label'=>'手机号'
            ],
//            'name',
            [
                'attribute' => 'name',
                'headerOptions' => ['width' => '150'],
            ],
//            'email:email',
            [
                'attribute' => 'email',
                'headerOptions' => ['width' => '250'],
            ],
//            'is_vest',
            [
                'attribute' => 'is_vest',
                'headerOptions' => ['width' => '150'],
                'value' => function($model){
                    return ($model -> is_vest == 1) ? '内部用户' :'普通用户';
                },
                'label'=>'用户类型'
            ],
            // 'head_img',
            // 'passwd',
            // 'pay_passwd',
            // 'real_name',
            // 'card_code',
//             'type',
//             'status',
            [
                'attribute' => 'status',
                'headerOptions' => ['width' => '150'],
                'value' => function ($model) {
                    return \backend\modules\base\models\Lookup::item('status',$model->status);
                },
                'label'=>'用户状态'
            ],
//             'use_money',
            [
                'attribute' => 'use_money',
                'headerOptions' => ['width' => '150'],
                'label'=>'可用资金'
            ],
//             'cur_bonus',
            [
                'attribute' => 'cur_bonus',
                'headerOptions' => ['width' => '100'],
                'label'=>'当前资金'
            ],
//             'freez_money',
            [
                'attribute' => 'freez_money',
                'headerOptions' => ['width' => '100'],
                'label'=>'冻结金额'
            ],
            // 'token',
            // 'token_time',
//             'create_at',
            [
                'attribute' => 'create_at',
                'headerOptions' => ['width' => '200'],
                'label'=>'注册时间'
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