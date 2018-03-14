<?php

namespace backend\modules\article\controllers;

use backend\modules\article\models\Article;
use Yii;
use backend\modules\article\models\Category;
use backend\modules\article\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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

//    //获取树
//    public static function getTree () {
//        //这里我们直接获取所有的数据，然后通过程序进行处理
//        //在无限极分类中最忌讳的是对数据库进行层层操作，也就很容易造成内存溢出
//        //最后电脑死机的结果
//
//        $data = Category::find()->all();
//        $new_data = Category::find()->where(['pid'=>0])->all();
//        foreach ($new_data as $v){
//            $pid = $v['id'];
//          return self::_generateTree($data,$pid);
//        }
//    }
//    private static function _generateTree ($data,$pid) {
//        $tree = [];
//        if ($data && is_array($data)) {
//            foreach($data as $v) {
//                if($v['pid'] == $pid) {
//                    $tree[] = [
//                        'id' => $v['id'],
//                        'name' => $v['name'],
//                        'sort'=>$v['sort'],
//                        'status'=>$v['status'],
//                        'pid' => $v['pid'],
//                    ];
//                }
//            }
//        }
//        return $tree;
//    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
//        $data = self::getTree();
//        //为了方便测试，我们这里以json格式输出
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        return $data;
    }

    /**
     * Displays a single Category model.
     * @param string $id
     * @param string $name
     * @return mixed
     */
    public function actionView($id, $name)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $name),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '新增分类成功!');
            return $this->redirect(['view', 'id' => $model->id, 'name' => $model->name]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @param string $name
     * @return mixed
     */
    public function actionUpdate($id, $name)
    {
        $model = $this->findModel($id, $name);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', '更新分类成功!');
            return $this->redirect(['view', 'id' => $model->id, 'name' => $model->name]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $name
     * @return mixed
     */
    public function actionDelete($id, $name)
    {
        $this->findModel($id, $name)->delete();
        Yii::$app->getSession()->setFlash('success', '删除分类成功!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $name
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $name)
    {
        if (($model = Category::findOne(['id' => $id, 'name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionNew($id)
    {
        $model = new Category();
        $model->pid = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('new', [
                'model' => $model,
            ]);
        }
    }
    public function actionAuth($id,$name)
    {
        $model = $this->findModel($id,$name);
        if ($model->status == 1)
        {
            $model->status = 0;
        }
        else
        {
            $model->status = 1;
        }

        $model->save();
        return $this->redirect(['index']);
    }

}
