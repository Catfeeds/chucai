<?php

namespace wechat\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "wechat_menu".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property integer $pid
 * @property string $url
 * @property string $wx_key
 * @property integer $sort
 * @property integer $status
 */
class WechatMenu extends \yii\db\ActiveRecord
{
    private static $_item_arr;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pid', 'sort', 'status'], 'integer'],
            [['type'], 'string', 'max' => 64],
            [['name'], 'string', 'max' => 20],
            [['url', 'wx_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', '按钮类型'),
            'name' => Yii::t('app', '按钮标题'),
            'pid' => Yii::t('app', '上级'),
            'url' => Yii::t('app', '跳转链接'),
            'wx_key' => Yii::t('app', '按钮键值'),
            'sort' => Yii::t('app', '排序（值越大、越靠前）'),
            'status' => Yii::t('app', '状态'),
        ];
    }
    /**
     * 获取菜单列表
     */
    public static function parents(){
        $res_data = array();
        $res_data[0] = "顶级菜单";
        $modles = self::findAll(['pid'=>0]);
        foreach ($modles as $model) {
            $res_data[$model->id] = $model->name;
        }
        return $res_data;
    }
    
    
    public static function parent($id){
        if ($id <= 0)
        {
            return "顶级菜单";
        }
        return  self::findOne($id)->name;
    }
    
    
}
