<?php
use wechat\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" style="height:100% !important;">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page" style="height:100%;background: url('../../images/login_bg.png') no-repeat 0 0;background-size: 100% 100%;">

<?php $this->beginBody() ?>

    <?= $content ?>
<script type="text/javascript">
             // 基于准备好的dom，初始化echarts实例
             document.onreadystatechange = completeLoading;
             function completeLoading() {
                $("body, html").css("height","100%");
             }
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
