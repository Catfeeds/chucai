<?php

namespace backend\modules\bank\models;

use Yii;

/**
 * This is the model class for table "{{%bank}}".
 *
 * @property string $id
 * @property string $name
 * @property string $code
 * @property integer $status
 * @property string $logo
 * @property string $rgb
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bank}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'code', 'rgb'], 'string', 'max' => 50],
            [['logo'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '银行ID'),
            'name' => Yii::t('app', '银行名称'),
            'code' => Yii::t('app', '银行代码(英文简称)'),
            'status' => Yii::t('app', '状态(1.启用，0.禁用)'),
            'logo' => Yii::t('app', 'Logo'),
            'rgb' => Yii::t('app', '背景颜色'),
        ];
    }

    public static function getBank($id){
        $res_data = false;
        $modles = Bank::find()->where(['id'=>$id])->one();
        if (!empty($modles))
        {
            $res_data = $modles->name;
        }
        return $res_data;
    }
}
