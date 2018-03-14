<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\GoodCategory */

$this->title = Yii::t('app', 'Update Good Category:', [
    'modelClass' => 'Good Category',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Good Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="good-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
