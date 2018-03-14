<?php

namespace backend\modules\adminuser\controllers;

use Yii;
use backend\modules\adminuser\models\Adminuser;
use backend\modules\adminuser\models\AdminuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\menu\models\MenuAuthUser;
use backend\modules\menu\models\MenuAuth;
/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends Controller
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
     * Lists all Adminuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
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
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $getdata = Yii::$app->request->post();
        $model = new Adminuser();

        if ($model->load(Yii::$app->request->post())) {
            $user = Adminuser::find()->where(['username'=>$getdata['Adminuser']['username']])->one();
            if(!$user){
                $model->save();
                Yii::$app->getSession()->setFlash('success', '新增用户成功!');
                return $this->redirect(['index']);
            }
            else{
                Yii::$app->getSession()->setFlash('warning', '该用户已存在!');

                return $this->redirect(['index']);
            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    //菜单管理
    public function actionPrivilege($id)
    {
        $menu_auth_user = new MenuAuthUser();

        if(isset($_POST['newPri']))
        {
            $menu_auth_user->deleteAll(['uid'=>$id]);
            $newPri = $_POST['newPri'];
//            var_dump($newPri);die;
            foreach ($newPri as $item) {
                $model = new MenuAuthUser();
                $model->g_id = $item;
                $model->uid = $id;
//                var_dump($model);die;
//                $model->save();
                if (!$model->save()) {
//                    var_dump($model->errors);die;
                    Yii::$app->getSession()->setFlash('error', '该项权限保存失败了'."gid:{$item},uid:{$id}".json_encode($model->errors,JSON_UNESCAPED_UNICODE));
                }else{
                    Yii::$app->getSession()->setFlash('success', '权限保存成功!');
                }
            }
            return $this->redirect(['index']);
        }
        $item_arr = MenuAuth::find()->asArray()->all();
        //角色列表装载
        foreach ($item_arr as $item) {
            $items[$item['id']] = $item['name'];
        }


        $item_arr = $menu_auth_user->find()->asArray()->select(['g_id'])->where(['uid'=>$id])->asArray()->all();
        $selection = [];
        //当前用户拥有的角色
        foreach ($item_arr as $item) {
            $selection[] = $item['g_id'];
        }
//var_dump($items);die;
        return $this->renderAjax('privilege',
            [
                'id'=>$id,
                'selection'=>$selection,
                'items'=>$items,
            ]
        );
    }
    /**
     * Updates an existing Adminuser model.
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
     * Deletes an existing Adminuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('success', '删除账户成功!');
        return $this->redirect(['index']);
    }


    /**
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adminuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAuth($id)
    {
        $model = $this->findModel($id);
        if ($model->status == 10)
        {
            $model->status = 0;
        }
        else
        {
            $model->status = 10;
        }

        $model->save();
//         var_dump($model->errors);die;

        return $this->redirect(['index']);
    }
}
