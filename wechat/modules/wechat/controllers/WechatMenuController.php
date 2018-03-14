<?php

namespace wechat\modules\wechat\controllers;

use Yii;
use wechat\modules\wechat\models\WechatMenu;
use wechat\modules\wechat\models\WechatMenuSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\BaseController;

/**
 * WechatMenuController implements the CRUD actions for WechatMenu model.
 */
class WechatMenuController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all WechatMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WechatMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WechatMenu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WechatMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WechatMenu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WechatMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WechatMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    /**
     * 更新微信公众号菜单
     */
    public function actionPublish()
    {
        $wechat = \Yii::$app->wechat;
        $top_model = WechatMenu::find()->where(['status'=>1,'pid'=>0])->orderBy('sort desc')->limit(3)->asArray()->all();
        $res_data = array();
        foreach ($top_model as $v)
        {
            unset($info);
            $info = [
                'type'=>$v['type'],
                'name'=>$v['name'],
                'key'=>$v['wx_key'],
            ];
            if ($v['type'] == 'view')
            {
                $info['url'] = $v['url'];
            }
            $level_model = WechatMenu::find()->where(['status'=>1,'pid'=>$v['id']])->orderBy('sort desc')->limit(5)->asArray()->all();
            if (!empty($level_model))
            {
                unset($level_data);
                foreach ($level_model as $l_v)
                {
                    
                    $level_data[] = [
                        'type'=>$l_v['type'],
                        'name'=>$l_v['name'],
                        'key'=>$l_v['wx_key'],
                        'url'=>$l_v['url'],
                    ];
                }
                $info['sub_button'] = $level_data;
            }
            $res_data[] = $info;
        }
//        $data['button'] = $res_data;
    /**
     * 先删除原来的菜单
     */
        $wechat->deleteMenu();
        /**
         * 创建菜单
         */
       $wechat->createMenu($res_data);
       return $this->redirect(['index']);
//        var_dump(json_encode($data));die;
    }

    /**
     * Finds the WechatMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WechatMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WechatMenu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
