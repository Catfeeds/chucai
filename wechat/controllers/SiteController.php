<?php
namespace wechat\controllers;

use wechat\models\UploadForm;
use Qiniu\Auth;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//use common\models\AdminLoginForm;
use wechat\modules\rbac\models\AdminLoginForm;
use yii\web\UploadedFile;
use wechat\modules\menu\models\MenuAuth;
use wechat\modules\menu\models\Menu;

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
                        'actions' => ['login', 'error','upload'],
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

        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

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

        $model = new AdminLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /**
             * 获取权限
             * @var unknown
             */
            $menuGroup = MenuAuth::find()->joinWith('menuAuthUsers')->where(['menu_auth_user.uid'=>\Yii::$app->user->id])->one();
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
 
}
