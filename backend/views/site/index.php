<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<div class= "panel panel-success">
    <div class="panel-heading">
        <h1 class="panel-title">出彩管理系统</h1>
    </div>
    <div class="panel-body">
        <div id="container"  class="pull-center">
        </div>
    </div>
    <div class="panel panel-body">

        <div class="col-sm-6">
                <div class="panel-heading">
                    <span class="label label-primary pull-right">历史</span>
                    <h5>访客</h5>
                </div>
                <div class="panel-body">
                    <h1 class="no-margins"><?=\backend\assets\Helper::getHistoryVisNum()?></h1>
                    <small>访客</small>
                </div>

        </div>
        <div class="col-sm-6">

                <div class="panel-heading">
                    <span class="label label-danger pull-right">最近一个月</span>
                    <h5>活跃用户</h5>
                </div>
                <div class="panel-body">
                    <h1 class="no-margins"><?=\backend\assets\Helper::getMonthHistoryVisNum()?></h1>
                    <small><?= date('m')?>月</small>
                </div>
            </div>


    </div>

    <div class="panel panel-body">
        <table class="table table-striped table-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>登录IP</th>
                <th>登录时间</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($log as $vo):?>
                <tr>
                    <td><?=$vo['id']?></td>
                    <td><?=$vo['userphone']?></td>
                    <td><?=$vo['ip']?></td>
                    <td><?= $vo['create_time']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <!--分页-->
        <div class="f-r">
            <?= LinkPager::widget([
                'pagination'=>$pages,
                'firstPageLabel' => '首页',
                'nextPageLabel' => '下一页',
                'prevPageLabel' => '上一页',
                'lastPageLabel' => '末页',
            ]) ?>
        </div>
    </div>
</div>

</div>

<script src="http://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<script>
    var chart = Highcharts.chart('container', {
        title: {
            text: '出彩后台管理系统登录情况'
        },
        credits: { enabled:false }, //屏蔽右下角
        exporting: { enabled:false }, //屏蔽右上角
        subtitle: {
            text: '数据来源：cc1.99caihong.net'
        },
        xAxis: {
            categories: [<?=$HistoryMonthStr?>]
        },
        yAxis: {

            title: {
                text: '访客/人'
            },
            //min: 7.5, // 这个用来控制y轴的开始刻度（最小刻度），另外还有一个表示最大刻度的max属性
            startOnTick: false, // y轴坐标是否从某一刻度开始（这个设定与标题无关）
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '人',
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:,.0f} 人</b><br/>',
            shared: true
        },
        // legend: {
        //     layout: 'vertical',
        //     align: 'right',
        //     verticalAlign: 'middle'
        // },
        // plotOptions: {
        //     series: {
        //         label: {
        //             connectorAllowed: false
        //         },
        //         pointStart: 2010
        //     }
        // },
        series: [{
            name: '访客数',
            data: [<?=$HistoryMonthNum?>]
        }]
    });
</script>


