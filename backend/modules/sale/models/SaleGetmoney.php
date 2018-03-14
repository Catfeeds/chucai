<?php

namespace backend\modules\sale\models;

use Yii;

/**
 * This is the model class for table "{{%sale_getmoney}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $cash_no
 * @property string $cash_money
 * @property string $case_service_money
 * @property string $cash_time
 * @property integer $cash_type
 * @property integer $cash_bank_id
 * @property string $cash_card
 * @property integer $status
 * @property string $success_no
 * @property string $success_money
 * @property string $success_service_money
 * @property string $success_time
 * @property integer $rec
 * @property string $reccode
 * @property string $rec_monry
 * @property string $rec_time
 * @property string $rec_member
 * @property string $user_remarks
 * @property string $man_remarks
 * @property integer $review_status
 * @property integer $cash_out
 * @property string $pay_username
 * @property integer $pay_type
 * @property string $pay_card
 */
class SaleGetmoney extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sale_getmoney}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'pay_username', 'pay_type', 'pay_card'], 'required'],
            [['user_id', 'cash_type', 'cash_bank_id', 'pay_type'], 'integer'],
            [['cash_money', 'case_service_money'], 'number'],
            [['cash_time', 'success_time'], 'safe'],
            [['name', 'cash_no'], 'string', 'max' => 30],
            [['cash_card', 'pay_username', 'pay_card'], 'string', 'max' => 50],
            [['man_remarks'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '提款用户ID'),
            'name' => Yii::t('app', '提款用户名'),
            'cash_no' => Yii::t('app', '提款定单号'),
            'cash_money' => Yii::t('app', '提款金额'),
            'case_service_money' => Yii::t('app', '提款手续费'),
            'cash_time' => Yii::t('app', '提款时间'),
            'cash_type' => Yii::t('app', '提款类型  1银行卡  2支付宝'),
            'cash_bank_id' => Yii::t('app', 'Cash Bank ID'),
            'cash_card' => Yii::t('app', '提款帐号 支付宝帐号 或者 银行卡号'),
            'success_time' => Yii::t('app', '成功提款时间'),
            'man_remarks' => Yii::t('app', '管理员备注'),
            'pay_username' => Yii::t('app', '打款人'),
            'pay_type' => Yii::t('app', '2 支付宝 1 银行卡'),
            'pay_card' => Yii::t('app', '打款卡号'),
        ];
    }
}
