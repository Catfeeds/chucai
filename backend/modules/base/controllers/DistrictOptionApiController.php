<?php

namespace backend\modules\base\controllers;

/**
 * User: 张伟平
 * Remark:
 * Date: 2017-06-16 14:53:53
 * Copyright (c) 2016-2017 *********公司技术开发部
 */
use Yii;
use backend\modules\base\models\District;
use backend\modules\base\models\DistrictSearch;

use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DistrictController implements the CRUD actions for District model.
 */
class DistrictOptionApiController extends Controller
{

    public function actionIndex()
    {  $searchModel = new DistrictSearch();
        $getdata = \Yii::$app->request->post();
        $page = \Yii::$app->request->post('start_page',0);
        $size = \Yii::$app->request->post('pages',5);
        $dataProvider = $searchModel->searchApi($getdata,$page,$size);
        $res_data['total_pages'] =  $dataProvider->getTotalCount();
        $res_data['list'] = $dataProvider->getModels();
        return response(0,'success',$res_data);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionHospital()
    {
        $searchModel = new DistrictSearch();
        /*$getdata = [
            'id'=>330100,
        ];*/
        $getdata = \Yii::$app->request->post();
        $page = \Yii::$app->request->post('start_page',0);
        $size = \Yii::$app->request->post('pages',10);
        $dataProvider = $searchModel->searchApiHospital($getdata,$page,$size);
        $res_data['total_pages'] =  $dataProvider->getTotalCount();
        $res_data['list'] = $dataProvider->getModels();
//        foreach ($res_data['list'] as $value)
//        {
//            if(!empty($value['name'])){
//                $name_list[] = $value['name'];
//            }
//        }
//        var_dump($res_data['list']);die;
        return response(0,'success',$res_data);
    }

    public function actionCreate()
    {
        $model = new District();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = District::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
