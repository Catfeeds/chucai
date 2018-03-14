<?php

namespace backend\modules\menu\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $label
 * @property string $icon
 * @property string $url
 * @property integer $pid
 * @property integer $sort
 * @property integer $status
 * @property integer $level
 *
 * @property MenuAuthUser[] $menuAuthUsers
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'url'], 'required'],
            [['pid', 'sort', 'status', 'level'], 'integer'],
            [['label'], 'string', 'max' => 128],
            [['icon'], 'string', 'max' => 256],
            [['url'], 'string', 'max' => 514],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', '名称'),
            'icon' => Yii::t('app', '渲染'),
            'url' => Yii::t('app', '控制器'),
            'pid' => Yii::t('app', '父级id'),
            'sort' => Yii::t('app', '排序， 值越大，越靠前'),
            'status' => Yii::t('app', '状态 1：显示  -1：删除'),
            'level' => Yii::t('app', '等级'),
        ];
    }
    
    /**
     * 获取菜单列表
     */
    public static function items($level=0,$type=FALSE){
        $res_data = array();
        if ($type)
        {
            $modles = self::find()->where(['status'=>1])->orderBy('level asc,id asc')->all();
        }
        else 
        {
            $modles = self::find()->where(['status'=>1])->andFilterWhere(['<=','level',$level])->orderBy('level asc,id asc')->all();
            $res_data[0] = "顶级级菜单";
        } 
        foreach ($modles as $model) {
            $res_data[$model->id] = $model->label;
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
            $res_data = $modles->label;
        }
        return $res_data;
    }
    
    /**
     * 依据规则获取区域列表，并转化为字符串
     */
    public static function strByRules($rules)
    {
        $data = self::find()->where(['in','id',explode(',', $rules)])->orderBy('sort asc')->asArray()->all();
    
        $res_data = '';
        foreach ($data as $v)
        {
            $res_data .= $v['label'].';';
        }
        return $res_data;
    }
    

    
}
