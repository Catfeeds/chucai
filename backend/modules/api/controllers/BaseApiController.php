<?php

namespace backend\modules\api\controllers;
use yii\rest\Controller;
use backend\modules\base\models\District;
use backend\modules\base\models\Nationality;
use backend\modules\base\models\Educational;
class BaseApiController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * 标签参数列表获取
     */
    public function actionLables()
    {
        if (!\Yii::$app->request->isPost) {
        
            return response(10001,'invalid data',[]);
        }
        /**
         * 区域列表
         */
        $resdata['dtList'] = District::find()->where(['status'=>1])->orderBy('sort asc')->asArray()->all();
        /**
         * 国籍列表
         */
        $resdata['naList'] = Nationality::find()->where(['status'=>1])->orderBy('sort asc')->asArray()->all();
        /**
         * 学历列表
         */
        $resdata['sgList'] = Educational::find()->where(['status'=>1])->orderBy('sort asc')->asArray()->all();
        return response(0,'success',$resdata);
    }
    

}
