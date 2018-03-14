<?php

namespace backend\modules\article\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $sort
 * @property integer $status
 * @property integer $pid
 * @property string $position
 * @property integer $model_sn
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort', 'status', 'pid', 'model_sn'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['position'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '文章分类表ID'),
            'name' => Yii::t('app', '分类名称'),
            'sort' => Yii::t('app', '排序'),
            'status' => Yii::t('app', '状态(1.启用，0.禁用)'),
            'pid' => Yii::t('app', '父ID'),
            'position' => Yii::t('app', '显示位置(top上,middle中,bottom下)'),
            'model_sn' => Yii::t('app', '模板编码'),
        ];
    }

    /**
     * 获取菜单列表
     */
    public static function items(){

        $res_data = array();
        $res_data[0] = '顶级分类';
        $modles = self::find()->where(['pid'=>0])->orderBy('id asc')->all();
        foreach ($modles as $model) {
            $res_data[$model->id] = $model->name;
        }
//        var_dump($res_data);die;
        return $res_data;

    }
    /**
     * 获取指定值
     */
    public static function item($id){
        $res_data = false;
        $model = self::find()->where(['id'=>$id])->one();
        if (!empty($model))
        {
            if($model->pid == 0){
                $res_data = $model->name;
            }
            else{
                $res_data = '├─ '."$model->name";
            }
        }
        return $res_data;
    }
}
