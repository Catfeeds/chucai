<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\sale\models\SaleUserpaylog */

$this->title = Yii::t('app', 'Create Sale Userpaylog');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sale Userpaylogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-userpaylog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
