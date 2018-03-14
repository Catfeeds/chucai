<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\base\models\Vocations */

$this->title = Yii::t('app', 'Create Vocations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Vocations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vocations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
