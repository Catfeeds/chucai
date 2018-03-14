<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\order\models\UserOrder */

$this->title = Yii::t('app', 'Create User Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
