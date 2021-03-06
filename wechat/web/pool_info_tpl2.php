<?php 

use wechat\modules\base\models\Lookup;
use wechat\modules\base\models\District;
use wechat\modules\base\models\Nationality;
use wechat\modules\base\models\Educational;
use wechat\modules\base\models\Clans;
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <title>平湖人才</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="B">
    <meta name="author" content="">
    <!-- Site CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div style="text-align: center;padding: 0 0 20px 0;">
    <h3><b>平湖籍人才记录表</b></h3>
</div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="width: 20%">
                                <b>姓名：</b>
                            </td>
                            <td colspan="2"><?= $model->name ?></td>
                            <td rowspan="6" style="width: 30%"><img alt="" width="100%" src="<?= $model->img_url ?>"></td>
                        </tr>
                        <tr>
                            <td>
                                <b>性别：</b>
                            </td>
                            <td colspan="2"><?= Lookup::item('system-sex', $model->sex) ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>所属区域：</b>
                            </td>
                            <td colspan="2"><?= District::item($model->dt_id) ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>所属地：</b>
                            </td>
                            <td colspan="2"><?= District::item($model->homeplace) ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>出生年月日：</b>
                            </td>
                            <td colspan="2"><?= $model->birthday ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>国籍：</b>
                            </td>
                            <td colspan="2"><?= Nationality::item($model->na_id) ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">
                                <b>最高学历：</b>
                            </td>
                            <td ><?= Educational::item($model->sh_id) ?></td>
                            <td style="width: 20%;">
                                <b>毕业院校及专业：</b>
                            </td>
                            <td ><?= $model->school ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">
                                <b>职业资格：</b>
                            </td>
                            <td ><?= $model->vocation ?></td>
                            <td style="width: 20%;">
                                <b>专业技术资格：</b>
                            </td>
                            <td ><?= $model->skill ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">
                                <b>党派：</b>
                            </td>
                            <td ><?= Clans::item($model->clan) ?></td>
                            <td style="width: 20%;">
                                <b>婚否：</b>
                            </td>
                            <td ><?= Lookup::item('member-marry', $model->is_marry) ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">
                                <b>现工作及职务：</b>
                            </td>
                            <td ><?= $model->job ?></td>
                            <td style="width: 20%;">
                                <b>现工作(学习)单位地址：</b>
                            </td>
                            <td ><?= $model->job_address ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">
                                <b>手机号码：</b>
                            </td>
                            <td ><?= $model->tel ?></td>
                            <td style="width: 20%;">
                                <b>微信号：</b>
                            </td>
                            <td ><?= $model->wechat ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">
                                <b>邮箱：</b>
                            </td>
                            <td ><?= $model->email ?></td>
                            <td style="width: 20%;">
                                <b>固定电话：</b>
                            </td>
                            <td ><?= $model->telephone ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>个人学习简历（从初中填起）：</b><br/><br/><br/><br/>
                            </td>
                            <td colspan="3"><?= $model->resume ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>工作经历：</b><br/><br/><br/><br/>
                            </td>
                            <td colspan="3"><?= $model->work_history ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>个人专业领域、主要成果、荣誉称号等：</b><br/><br/><br/><br/>
                            </td>
                            <td colspan="3"><?= $model->fruits ?></td>
                        </tr>
                        <tr>
                            <td>
                                <b>创办公司所属行业、主营业务及规模等：</b><br/><br/><br/><br/>
                            </td>
                            <td colspan="3"><?= $model->service ?></td>
                        </tr>

                    </tbody>
                </table>


<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    document.onreadystatechange = completeLoading;
    function completeLoading() {
        if (document.readyState == "complete") {
            window.print();
        }
    }




</script>
</body>
</html>
