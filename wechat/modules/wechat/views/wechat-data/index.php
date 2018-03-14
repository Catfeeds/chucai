<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel wechat\modules\wechat\models\WechatDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Wechat Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Wechat Data'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'msg_type',
            'to_user_name',
            'from_user_name',
            'content:ntext',
            // 'msg_id',
            // 'create_time',
            // 'pic_url:url',
            // 'media_id',
            // 'format',
            // 'recognition',
            // 'thumb_media_id',
            // 'location_x',
            // 'location_y',
            // 'scale',
            // 'label',
            // 'title',
            // 'description',
            // 'url:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
