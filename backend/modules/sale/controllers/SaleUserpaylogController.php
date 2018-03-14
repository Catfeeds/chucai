<?php

namespace backend\modules\sale\controllers;

use Yii;
use backend\modules\sale\models\SaleUserpaylog;
use backend\modules\sale\models\SaleUserpaylogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaleUserpaylogController implements the CRUD actions for SaleUserpaylog model.
 */
class SaleUserpaylogController extends Controller
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
     * Lists all SaleUserpaylog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SaleUserpaylogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SaleUserpaylog model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SaleUserpaylog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SaleUserpaylog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SaleUserpaylog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing SaleUserpaylog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SaleUserpaylog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SaleUserpaylog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SaleUserpaylog::findOne($id)) !== null) {
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
                $count= SaleUserpaylog::deleteAll($para);//删除id为这些的数据
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
}
