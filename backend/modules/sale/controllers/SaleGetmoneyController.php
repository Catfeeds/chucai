<?php

namespace backend\modules\sale\controllers;

use backend\modules\sale\models\SaleUserpaylog;
use backend\modules\user\models\User;
use Yii;
use backend\modules\sale\models\SaleGetmoney;
use backend\modules\sale\models\SaleGetmoneySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaleGetmoneyController implements the CRUD actions for SaleGetmoney model.
 */
class SaleGetmoneyController extends Controller
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
     * Lists all SaleGetmoney models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SaleGetmoneySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SaleGetmoney model.
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
     * Creates a new SaleGetmoney model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SaleGetmoney();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SaleGetmoney model.
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
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SaleGetmoney model.
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
     * Finds the SaleGetmoney model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SaleGetmoney the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SaleGetmoney::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionDel()
    {
        if(Yii::$app->request->isAjax) {
            $para = Yii::$app->request->post();
//           var_dump($para);die;
            if(empty($para)){
                return $this->redirect(['index']);
            }else{
                $count= SaleGetmoney::deleteAll($para);//删除id为这些的数据
                if($count>0)
                {
                    Yii::$app->getSession()->setFlash('success', '批量删除成功!');
                    return $this->redirect(['index']);
                }else{
                    Yii::$app->getSession()->setFlash('danger', '批量删除失败!');
                    return $this->redirect(['index']);
                }
            }


        }else{
            return false;
        }
    }

    public function actionHandle($id)
    {
        $model = $this->findModel($id);
//        var_dump($user_refund);die;
        $model->success_time = time();
//        var_dump($model->status);die;

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            $this->actionNewLog($id);
            $this->actionUpdateRefund($id);
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->renderAjax('handle', [
                'model' => $model,
            ]);
        }

    }

    public function actionNewLog($id){
        $model = $this->findModel($id);
        $log = new SaleUserpaylog();
        $add = [
            'user_id' => $model->user_id,
            'order_id' => $model->cash_no,
            'type' => 1,
            'user_name' =>$model->name,
            'pay_money' =>  $model->cash_money,
            'pay_poundage' =>  $model->case_service_money,
            'status' => 1,
            'add_time'=>date("Y-m-d H:i:s",time())
        ];
//            var_dump($add);die;
        $log->setAttributes($add);
        $log->save();
    }
    public function actionUpdateRefund($id)
    {
        $model = $this->findModel($id);
        $user_refund = User::find()->where(['id'=>$model->user_id])->one();
        $user_refund->freez_money = $user_refund->freez_money-$model->cash_money;
        $user_refund->save();
    }



}
