<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\rbac\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Yii::$app->user->can('resetPassword')?Html::a('创建管理员', ['create'], ['class' => 'btn btn-success']):'' ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            // 'email:email',
            // 'status',
//             'created_at',
//            'updated_at',
            [
                'attribute'=>'created_at',
                'value'=>
                    function($model){
                        return date('Y-m-d H:i:s',$model->created_at);}
            ],
//            [
//                'attribute'=>'updated_at',
//                'value'=>
//                    function($model){
//                        return date('Y-m-d H:i:s',$model->updated_at);}
//            ],

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {resetpwd} {privilege}',   //{update}
                'buttons'=>[
                    'resetpwd'=>function($url,$model,$key)
                    {
                        $options=[
                            'title'=>Yii::t('yii','重置密码'),
                            'aria-label'=>Yii::t('yii','重置密码'),
                            'data-pjax'=>'0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-lock"></span>',$url,$options);
                    },

                    'privilege'=>function($url,$model,$key)
                    {
                        $options=[
                            'title'=>Yii::t('yii','权限'),
                            'aria-label'=>Yii::t('yii','权限'),
                            'data-pjax'=>'0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-user"></span>',$url,$options);
                    },

                ],
            ],
        ],
    ]); ?>
</div>
