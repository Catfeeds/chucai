<?php

namespace backend\modules\base\models;

use Yii;

/**
 * This is the model class for table "clans".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $status
 */
class Clans extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '党派名称'),
            'sort' => Yii::t('app', '排序'),
            'status' => Yii::t('app', '状态： 1:正常 -1：删除'),
        ];
    }
    
    /**
     * 获取菜单列表
     */
    public static function items(){
        $res_data = array();
        $modles = self::find()->where(['status'=>1])->orderBy('sort asc')->all();
        foreach ($modles as $model) {
            $res_data[$model->id] = $model->name;
        }
        return $res_data;
    }
    /**
     * 获取指定值
     */
    public static function item($id){
        $res_data = false;
        $modles = self::find()->where(['id'=>$id,'status'=>1])->one();
        if (!empty($modles))
        {
            $res_data = $modles->name;
        }
        return $res_data;
    }
    
}
