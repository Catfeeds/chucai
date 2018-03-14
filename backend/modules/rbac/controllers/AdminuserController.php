<?php

namespace backend\modules\rbac\controllers;

use backend\modules\rbac\models\AuthAssignment;
use backend\modules\rbac\models\AuthItem;
use backend\modules\rbac\models\SignupForm;
use Yii;
use backend\modules\rbac\models\Adminuser;
use backend\modules\rbac\models\AdminuserSearch;
use backend\modules\rbac\models\ResetpwdForm;
use yii\rbac\ManagerInterface;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        if (!Yii::$app->user->can('resetPassword')) {
            throw new ForbiddenHttpException('对不起，你没有进行该操作的权限。');
        }
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                return $this->redirect(['view', 'id' => $user->id]);
            }

        }
        return $this->render('create', [
            'model' => $model,
        ]);
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
            return $this->render('update', [
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

        return $this->redirect(['index']);
    }

    public function actionResetpwd($id)
    {
        $model = new ResetpwdForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->resetPassword($id)) {
                return $this->redirect(['index']);
            }

        }
        return $this->render('resetpwd', [
            'model' => $model,
        ]);
    }

    public function actionPrivilege($id)
    {
        $auth_item = new AuthItem();
        $item_arr = $auth_item->find()->select(['name','description'])
            ->where(['type'=>1])->asArray()->all();
        //角色列表装载
        foreach ($item_arr as $item) {
            $items[$item['name']] = $item['description'];
        }

        $auth_assignment = new AuthAssignment();
        $item_arr = $auth_assignment->find()->select(['item_name'])->where(['user_id'=>$id])->asArray()->all();
        $selection = [];
        //当前用户拥有的角色
        foreach ($item_arr as $item) {
            $selection[] = $item['item_name'];
        }

        if(isset($_POST['newPri']))
        {
            $auth_assignment->deleteAll(['user_id'=>$id]);
            $newPri = $_POST['newPri'];
            foreach ($newPri as $item) {
                $model = new AuthAssignment();
                $model->item_name = $item;
                $model->user_id = $id;
                $model->created_at = time();
                $model->save();
            }
//            AuthAssignment::deleteAll('user_id=:id',[':id'=>$id]);
//
//            $newPri = $_POST['newPri'];
//
//            $arrlength = count($newPri);
//
//            for($x=0;$x<$arrlength;$x++)
//            {
//                $aPri = new AuthAssignment();
//                $aPri->item_name = $newPri[$x];
//                $aPri->user_id = $id;
//                $aPri->created_at = time();
//
//                $aPri->save();
//            }
            return $this->redirect(['index']);
        }

        return $this->render('privilege',
            [
                'id'=>$id,
                'selection'=>$selection,
                'items'=>$items,
            ]
        );
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


}
