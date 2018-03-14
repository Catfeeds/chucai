<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\build\models\BuildImageSearch */
/* @var $form yii\widgets\ActiveForm */

$htmlpic = '';
foreach ($files as $key=>$v)
{
    $htmlpic .= '<li id="NICK_FILE_'.$key.'" class="state-complete"><p class="title">21.jpg</p><p class="imgWrap"><img src="'.$v.'"></p><p class="progress"><span style="display: none; width: 0px;"></span></p><div class="file-panel" style="height: 25px;"><span class="cancel nick-delete" data-id="NICK_FILE_'.$key.'" >删除</span></div><span class="success"></span><input type="hidden" class="form-control" name="img_nick_list[]" value="'.$v.'"></li>';
}
?>
<label for="department-name">图片列表</label>
<div class="fileupload fileupload-new">
<div class="img-preview">
</div>
</div>
<?= \iisns\webuploader\MultiImage::widget() ?>


<script type="text/javascript">
 
    document.onreadystatechange = compbutton;
    function compbutton() {
        var addhtml = '<?= $htmlpic ?>';
        $('.filelist').append(addhtml);
        $('#dndArea').addClass('element-invisible');
        $('.filelist').show();
        $('.statusBar').show();
        $(".nick-delete").click(function(){
  	  	  	$('#'+$(this).attr('data-id')).remove();
  	  	}); 
    }
</script>