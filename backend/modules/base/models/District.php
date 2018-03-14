<?php

namespace backend\modules\base\models;

use backend\modules\appoint\models\Hospital;
use Yii;

/**
 * This is the model class for table "district".
 *
 * @property string $id
 * @property string $name
 * @property integer $level
 * @property string $upid
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
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'level' => Yii::t('app', 'Level'),
            'upid' => Yii::t('app', 'Upid'),
        ];
    }
    
    /**
     * 获取菜单列表
     */
    public static function items($upid=0){
        $res_data = array();
        $modles = self::find()->where(['upid'=>$upid])->orderBy('id asc')->all();
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
        $modles = self::find()->where(['id'=>$id])->one();
        if (!empty($modles))
        {
            $res_data = $modles->name;
        }
        return $res_data;
    }

    //按级别查询子区域名称列表
    public static function getList($level=1,$id=NULL){
        $model = self::find()->where(['level'=>$level]);
        if ($level !=1 && isset($id)) {
            $model = $model->andWhere(['upid'=>$id]);
        }

        $data = $model->select(['id','name'])->asArray()->all();

        return $data;
    }

    public function getHospital()
    {
        return $this->hasMany(Hospital::className(), ['c_id' => 'id']);
    }
    
}
