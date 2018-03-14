<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property integer $upid
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'upid'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'level' => 'Level',
            'upid' => 'Upid',
        ];
    }

    /*
     * func:通过省市区名称获取ID
     * @param string $name      省市区名称
     * @level int    $level     级别1：省份 2：市 3：县/区
     * return int   $id         id值
     * by:MR.Chen
     * date:2017年6月27日14:42:56
     */
    public static function getId($name=null,$level=null)
    {
        $data = self::findOne(['name'=>$name,'level'=>$level]);
        return is_null($data)?null:$data->id;
    }
}
