<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\article\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<!--<h1><?/*= Html::encode($this->title) */?></h1>-->
<div class= "panel panel-default">
    <div class="panel-heading">

                <?= Html::a( '<i class="fa fa-pencil"></i>',['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>

            <div class="pull-right">
                <!-- <button type="button" class="btn btn-default light" onClick="<?/*=$model['top']['url']*/?>">
                    <i class="fa fa-chevron-left"></i>
                </button>-->



                <a href="<?=$model['top']['url']?>">
                    <button class="btn btn-success"><i class="fa fa-chevron-left"></i> </button>
                </a>

                <a href="<?=$model['bot']['url']?>">
                    <button class="btn btn-success"> <i class="fa fa-chevron-right"></i></button>
                </a>
                <!-- 下一篇 -->
                <!-- <button type="button" class="btn btn-default light" onClick="<?/*=$model['bot']['url']*/?>">
                    <i class="fa fa-chevron-right"></i>
                </button>-->
            </div>
    </div>
    <div style="padding: 15px;">
        <!-- message meta info -->
        <div class="text-center page-header">
            <h3 ><?= $model->title ?><span class="badge bg-green"><?php echo $model->view ?></span></h3>
           <!-- 阅读量<p class="badge"></p>
           -->

        </div>

        <!-- message header -->
        <div  align="center">
            <!-- <img src="__PUBLIC__/assets/img/avatars/1.jpg" class="img-responsive mw40 pull-left mr20"> -->
            <div class="pull-right mt5 clearfix">
                <span class="label bg-success mr10"><?php echo  \backend\modules\article\models\Category::item($model->cid);?></span>
                <!-- <span class="label bg-success">Co-Worker</span> -->
            </div>
            <h4 class="text-center">摘要： <?php echo $model->abstract ?></h4>
            <small class="text-center">作者:<?php echo $model->auth ?></small>

        </div>

        <hr class="mb15 mt15">
        <!-- message body -->
        <div class="message-body">
            <?php echo $model->content ?>
        </div>


    </div>

</div>
