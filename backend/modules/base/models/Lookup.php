<?php

namespace backend\modules\base\models;

use Yii;

/**
 * This is the model class for table "lookup".
 *
 * @property integer $id
 * @property string $name
 * @property integer $code
 * @property string $type
 * @property integer $position
 */
class Lookup extends \yii\db\ActiveRecord
{
    private static $_item_arr;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lookup}}';
    }
    public function rules()
    {
        return [
            [['name', 'code', 'type', 'position'], 'required'],
            [[ 'position'], 'integer'],
            [['name', 'type'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '名称（叫什么）'),
            'code' => Yii::t('app', '类编号'),
            'type' => Yii::t('app', '类编码'),
            'position' => Yii::t('app', '排序'),
        ];
    }
    
    public static function items($type){
        if (!isset(self::$_item_arr[$type])) {
            self::itemsLoad($type);
        }
    
        return self::$_item_arr[$type];
    }
    /**
     * 根据类型、代码值换取名称
     * @param $type 类型
     * @param $code 代码
     * @return bool
     */
    public static function item($type, $code){
        if (!isset(self::$_item_arr[$type])) {
            self::itemsLoad($type);
        }
    
        return @self::$_item_arr[$type][$code] ? @self::$_item_arr[$type][$code] : false;
    }
    
    /**
     * 将类的代码、名称关系初始化到静态数组中
     * @param $type
     */
    public static function itemsLoad($type){
        $modles = self::find()->where(['type'=>$type])->orderBy('position asc')->all();
        foreach ($modles as $model) {
            self::$_item_arr[$type][$model->code] = $model->name;
        }
    }
    
}
