<?php

namespace backend\modules\good\controllers;

use Yii;
use backend\modules\good\models\Good;
use backend\modules\good\models\GoodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodController implements the CRUD actions for Good model.
 */
class GoodController extends Controller
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
     * Lists all Good models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Good model.
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
     * Creates a new Good model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Good();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Good model.
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
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Good model.
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
     * Finds the Good model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Good the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Good::findOne($id)) !== null) {
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
                $count= Good::deleteAll($para);//删除id为这些的数据
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

    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = ltrim(Yii::$app->controller->module->getUniqueId() . '/' . $route, '/');
            }
            $route = ltrim($route,'/');
            $route = explode('/', $route);
            $path = explode('/', $this->route);
            if ($route[1] != $path[1] && $route !== $this->noDefaultRoute && $route !== $this->noDefaultAction) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function actionHandle($id)
    {
        $model = $this->findModel($id);
//        var_dump($user_refund);die;
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->renderAjax('handle', [
                'model' => $model,
            ]);
        }

    }
}
