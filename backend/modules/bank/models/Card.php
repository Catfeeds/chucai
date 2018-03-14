<?php

namespace backend\modules\bank\models;

use Yii;

/**
 * This is the model class for table "{{%card}}".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $bank_id
 * @property string $card_no
 * @property string $card_name
 * @property string $phone
 * @property string $province
 * @property string $city
 * @property string $open_bank
 * @property string $remarks
 * @property integer $status
 * @property integer $is_def
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'bank_id', 'card_no', 'is_def'], 'required'],
            [['user_id', 'bank_id', 'status', 'is_def'], 'integer'],
            [['card_no'], 'string', 'max' => 50],
            [['card_name', 'phone', 'province', 'city'], 'string', 'max' => 20],
            [['open_bank', 'remarks'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '开卡表ID'),
            'user_id' => Yii::t('app', '关联用户ID'),
            'bank_id' => Yii::t('app', '开卡银行'),
            'card_no' => Yii::t('app', '卡号'),
            'card_name' => Yii::t('app', '账户姓名'),
            'phone' => Yii::t('app', '银行卡绑定手机号'),
            'province' => Yii::t('app', '开卡省份'),
            'city' => Yii::t('app', '开卡市'),
            'open_bank' => Yii::t('app', '开户行'),
            'remarks' => Yii::t('app', '备注'),
            'status' => Yii::t('app', '银行卡状态(1.启用，0.禁用)'),
            'is_def' => Yii::t('app', '是否默认 1默认 0非默认'),
        ];
    }
}
