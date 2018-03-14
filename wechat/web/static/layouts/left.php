 <?php 
 
     $cache = \Yii::$app->cache;
     $menuList = $cache->get('user_menu');
     $sys_menu = array();
     foreach ($menuList as $v)
     {
         unset($info);
         unset($infoList);
         $info =  [
                     'label' => Yii::t('app', $v['label']),
                     'icon' => $v['icon'],
                     'url' => [''.$v['url']],
                 ];
         foreach ($v['list'] as $v_list)
         {
             unset($info1);
             unset($infoList1);
             $info1 = [
                     'label' => Yii::t('app', $v_list['label']),
                     'icon' => $v_list['icon'],
                     'url' => [''.$v_list['url']],
                 ];
             foreach ($v_list['list'] as $v_list_l)
             {
                 $infoList1[] = [
                     'label' => Yii::t('app', $v_list_l['label']),
                     'icon' => $v_list_l['icon'],
                     'url' => [''.$v_list_l['url']],
                 ];
             }
             if (!empty($infoList1))
             {
                 $info1['items'] = $infoList1;
             }
             $infoList[] = $info1;
             
         }
         if (!empty($infoList))
         {
             $info['items'] = $infoList;
         }
         
         $sys_menu[] = $info;
     }
 ?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel 
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        -->
        <!-- search form 
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
     search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $sys_menu,
            ]
        ) ?>

    </section>

</aside>
