<?php

namespace backend\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%base_useriotype}}".
 *
 * @property integer $uo_id
 * @property integer $uo_inout
 * @property integer $uo_fatherid
 * @property integer $uo_level
 * @property string $uo_note
 * @property string $uo_shortcode
 * @property integer $uo_ordernum
 * @property integer $uo_isshow
 */
class BaseUseriotype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%base_useriotype}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uo_inout', 'uo_fatherid', 'uo_level', 'uo_ordernum', 'uo_isshow'], 'integer'],
            [['uo_note', 'uo_shortcode'], 'required'],
            [['uo_note'], 'string', 'max' => 30],
            [['uo_shortcode'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uo_id' => Yii::t('app', 'Uo ID'),
            'uo_inout' => Yii::t('app', 'Uo Inout'),
            'uo_fatherid' => Yii::t('app', 'Uo Fatherid'),
            'uo_level' => Yii::t('app', 'Uo Level'),
            'uo_note' => Yii::t('app', 'Uo Note'),
            'uo_shortcode' => Yii::t('app', 'Uo Shortcode'),
            'uo_ordernum' => Yii::t('app', 'Uo Ordernum'),
            'uo_isshow' => Yii::t('app', 'Uo Isshow'),
        ];
    }

    public static function item($id){
        $res_data = false;
        $modles = self::find()->where(['uo_id'=>$id])->one();
        if (!empty($modles))
        {
            $res_data = $modles->uo_note;
        }
        return $res_data;
    }

}
