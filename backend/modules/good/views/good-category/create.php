<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\GoodCategory */

$this->title = Yii::t('app', 'Create Good Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Good Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class= "panel panel-default">
    <div class="panel-heading">

        <h2 class="panel-title"><?= Html::encode($this->title) ?></h2>
    </div>
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
