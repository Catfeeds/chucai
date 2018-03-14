<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\good\models\GoodImgs */

$this->title = Yii::t('app', 'Create Good Imgs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Good Imgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-imgs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
