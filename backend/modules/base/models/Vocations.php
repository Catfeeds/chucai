<?php

namespace backend\modules\base\models;

use Yii;

/**
 * This is the model class for table "vocations".
 *
 * @property integer $v_id
 * @property string $name
 * @property integer $sort
 * @property integer $status
 */
class Vocations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vocations';
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
            'v_id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '名称'),
            'sort' => Yii::t('app', '排序'),
            'status' => Yii::t('app', '状态 1：正常 -1：删除'),
        ];
    }
    /**
     * 获取菜单列表
     */
    public static function items(){
        $res_data = array();
        $modles = self::find()->where(['status'=>1])->orderBy('sort asc')->all();
        foreach ($modles as $model) {
            $res_data[$model->v_id] = $model->name;
        }
        return $res_data;
    }
    /**
     * 获取指定值
     */
    public static function item($v_id){
        $res_data = false;
        $modles = self::find()->where(['v_id'=>$v_id,'status'=>1])->one();
        if (!empty($modles))
        {
            $res_data = $modles->name;
        }
        return $res_data;
    }
}
