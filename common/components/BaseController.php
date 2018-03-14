<?php


namespace common\components;

use Yii;
use yii\web\Controller;

/**
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class BaseController extends Controller
{
    public function beforeAction($action)
    {
        //如果未登录，则直接返回
        if(Yii::$app->user->isGuest){
            return false;
        }
        return true;
    }
    public function init()
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        
        
    }
}
