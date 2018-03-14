<?php

namespace backend\modules\menu\models;

use Yii;

/**
 * This is the model class for table "menu_auth".
 *
 * @property integer $id
 * @property string $name
 * @property string $rules
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class MenuAuth extends \yii\db\ActiveRecord
{
    public $boxlist;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_auth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'boxlist'], 'required'],
            [['rules'], 'string'],
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '名称'),
            'rules' => Yii::t('app', '拥有菜单'),
            'status' => Yii::t('app', '状态'),
            'create_time' => Yii::t('app', '新增时间'),
            'update_time' => Yii::t('app', '更新时间'),
            'boxlist' =>  Yii::t('app', '拥有菜单权限'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuAuthUsers()
    {
        return $this->hasMany(MenuAuthUser::className(), ['g_id' => 'id']);
    }
    
    public function beforeSave($insert)
    {
        $this->update_time = date('Y-m-d H:i:s',time());
         
        $this->rules = implode(',', $this->boxlist);
         
        
        return parent::beforeSave($insert);
    }
    
    /**
     * 获取菜单列表
     */
    public static function items(){
        $res_data = array();

        $modles = self::find()->where(['status'=>1])->orderBy('create_time asc')->all();
    
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
        $modles = self::find()->where(['id'=>$id,'status'=>1])->one();
        if (!empty($modles))
        {
            $res_data = $modles->name;
        }
        return $res_data;
    }
    
    
    
}
