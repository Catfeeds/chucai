<?php
?>
<div class="item">
    <h4 style="font-weight:bold"><?= $model->name ?></h4>
    <p>
        手机号：<?= $model->phone ?>
    </p>
    <p>
        用户名：<?= $model->name ?>
    </p>
    <p>
        邮箱：<?= $model->email ?>
    </p>
    <p>
        用户类型：<?=
       $model->is_vest ==1 ? '内部用户':'普通用户'
        ?>
    </p>
    <p>
        用户状态：
        <?php echo \backend\modules\base\models\Lookup::item('status',$model->status); ?>
    </p>
    <p style="color:orangered">
        注册时间：<?= $model->create_at ?>
    </p>
    <div style="text-align:left">
        <?= \yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], ['title' => '查看']) ?>
        <!--
        <?= \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['create', 'id' => $model->id], ['title' => '修改']) ?>
        <?= \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
            'title' => '删除',
            'data' => [
                'confirm' => '您确定真的要删除吗？',
                'method' => 'post',
            ]
        ]) ?>
        -->
    </div>
</div>
