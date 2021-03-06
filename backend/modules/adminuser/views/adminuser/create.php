<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\adminuser\models\Adminuser */

$this->title = Yii::t('app', 'Create Adminuser');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Adminusers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
