<?php
namespace backend\controllers;

use backend\models\Log;
use backend\models\UploadForm;
use Qiniu\Auth;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//use common\models\AdminLoginForm;
use backend\modules\rbac\models\AdminLoginForm;
use yii\web\UploadedFile;
use backend\modules\menu\models\MenuAuth;
use backend\modules\menu\models\Menu;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','upload','webupload','captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'webupload' => 'yidashi\webuploader\Action',
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 5,
                'minLength' => 4,
                'width' => 130,
                'height' => 40,
                'offset'=>4,
                'padding' => 5,//间距
//                'backColor'=>0x0000ff,//背景颜色
//                'foreColor'=>0xffffff,     //字体颜色
                ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
     
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /**
             * 获取权限
             * @var unknown
             */
            $model->loginLog();
//            var_dump(\Yii::$app->user->id);die;
            $menuGroup = MenuAuth::find()->joinWith('menuAuthUsers')->where(['tp_menu_auth_user.uid'=>\Yii::$app->user->id])->one();
//            var_dump($menuGroup);die;
            /**
             * 获取权限列表
            */
            $menuarr = array();
            if (!empty($menuGroup->rules))
            {
                $menuarr = explode(',', $menuGroup->rules);
            
            }
            /**
             * 顶级菜单获取
             * @var unknown
             */
            $menuList = Menu::find()->where(['in','id',$menuarr])->andWhere(['pid'=>0])->orderBy('sort desc')->asArray()->all();
            $menuAuth = array();
            foreach ($menuList as $v)
            {
                /**
                 * 二级菜单获取
                 * @var unknown
                 */
                $v['list'] = Menu::find()->where(['in','id',$menuarr])->andWhere(['pid'=>$v['id']])->orderBy('sort desc')->asArray()->all();
                /**
                 * 三级菜单获取
                 * @var unknown
                 */
                foreach ($v['list'] as $key=>$v_l)
                {
                    $v['list'][$key]['list'] = Menu::find()->where(['in','id',$menuarr])->andWhere(['pid'=>$v_l['id']])->orderBy('sort desc')->asArray()->all();
                }
                $menuAuth[] = $v;
            }
            $cache = \Yii::$app->cache;
            $cache->set('user_menu', $menuAuth);
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionUpload(){
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($ret=$model->upload()) {
                // 文件上传成功
            }
            print_r($ret);die;
        }

        return $this->render('upload', ['model' => $model]);
    }
    public function actionIndex()
    {
        //登录记录
        $query = Log::find();
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count,'pageSize' => '10']);
        $log = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id desc')
            ->all();

        $sql = "SELECT *,FROM_UNIXTIME(create_time,'%Y-%m') as period,COUNT(*) as times FROM tp_log GROUP BY period LIMIT 12";
        $History = Yii::$app->db->createCommand($sql)->queryAll();
        $HistoryMonthStr = '';
        $HistoryMonthNum = '';
        foreach($History as $val){
            $HistoryMonthStr .= "'".$val['period']."',";
            $HistoryMonthNum .= $val['times'].",";
        }
        $HistoryMonthStr = substr($HistoryMonthStr,0,-1);
//var_dump($History);die;
        $HistoryMonthNum = substr($HistoryMonthNum,0,-1);
        return $this->render('index',[
            'log' => $log,
            'pages' => $pages,
            'HistoryMonthStr' => $HistoryMonthStr,
            'HistoryMonthNum' => $HistoryMonthNum,
        ]);
    }



}
