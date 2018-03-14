<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use yii\helpers\Html;
// use backend\assets\AppAsset;
// use yii\widgets\Breadcrumbs;
// use common\widgets\Alert;

// AppAsset::register($this);


?>
<div class="content-wrapper">
   <div class="container" style="padding: 10px;width:100%;">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => '<i class="fa fa-home"></i>' . Html::encode(Yii::t('yii', 'Home')),
                'url' => Yii::$app->homeUrl,
                'encode' => false,
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options' => [
                    'class'=>'breadcrumb'
            ]
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?> 
    </div>
</div>

<footer class="footer">
    <div class="container">
     
        <p class="pull-right"><?= Yii::t('app', 'My Company') ?> @ <?=   date('Y') ?></p>
    </div>
</footer>
