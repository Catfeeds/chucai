<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\menu\models\Menu;

/* @var $this yii\web\View */
/* @var $model backend\modules\menu\models\MenuAuth */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu Auths'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "panel panel-default">
    <div class="panel-heading">

    <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
//             'rules:ntext',
            [
                'attribute'=>'rules',
                // 'label'=>'管理区域',
                'contentOptions' => ['style' => 'word-break: break-all;white-space: normal;', 'width' => '15%'],
                'value' =>   Menu::strByRules($model->rules),
            ],
//             'status',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
</div>