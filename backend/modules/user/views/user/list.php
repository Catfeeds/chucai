<?php

use yii\helpers\Html;

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class= "panel panel-default">
    <div class="panel-heading">

                    <h2 class="panel-title" ><?= Html::encode($this->title) ?></h2>
    </div>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--                    <p>-->
<!---->
<!--                        --><?php
//
//                        $selection = \yii\helpers\ArrayHelper::getValue($_GET,'sort','add_time')
//
//                        ?>
<!---->
<!--                        排序：--><?php //echo Html::dropDownList('sortDropdown',$selection,[''=>'---请选择---','add_time'=>'时间倒序','-add_time'=>'时间升序']) ?>
<!---->
<!--                    </p>-->

    <div class="panel-body">
        <div id="search" style="display:none"><?php echo $this->render('_search', ['model' => $searchModel]); ?> </div>
        <button class="btn btn-sm btn-danger pull-right " id="buttonsearch"><i class="glyphicon glyphicon-search"></i>搜索</button>
        <?= Html::a('<i class="fa fa-reply"></i>'."返回", ['/user/user/list'] , ["class" => "btn-sm btn btn-success pull-left"], ['target' => "_self"]) ?>
    </div>
    <div class="panel-body">
        <?= \yii\widgets\ListView::widget([

                        'dataProvider' => $dataProvider,

                        'itemView' => '_item',

                         'options' => ['class'=>'list-view'],

                        'itemOptions' => [//针对渲染的单个item
                            'tag' => 'div',
                            'class' => 'col-lg-3'
                            ],
                        'layout' => '{items}<div class="col-lg-12 sum-pager">{summary}{pager}</div>',
                        'pager' => [
                            //'options' => ['class' => 'hidden'],//关闭分页（默认开启）
                            /* 分页按钮设置 */
                            'maxButtonCount' => 5,//最多显示几个分页按钮
                            'firstPageLabel' => '首页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'lastPageLabel' => '尾页'
                          ]
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

                    ?>
    </div>
</div>