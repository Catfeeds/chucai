<?php

namespace backend\modules\sale\models;

use backend\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%sale_banktmp}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $buit_id
 * @property string $buyer_id
 * @property string $buyer_logon_id
 * @property string $recharge_money
 * @property string $service_money
 * @property string $receipt_amount
 * @property string $order_no
 * @property string $trade_no
 * @property string $subject
 * @property string $body
 * @property string $create_time
 * @property string $pay_time
 * @property string $notify_time
 * @property string $abbpay_time
 * @property integer $status
 * @property string $remarks
 * @property string $flag
 * @property string $post
 */
class SaleBanktmp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sale_banktmp}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'buit_id', 'status'], 'integer'],
            [['create_time', 'pay_time', 'notify_time'], 'safe'],
            [['buyer_id', 'trade_no'], 'string', 'max' => 50],
            [['buyer_logon_id'], 'string', 'max' => 12],
            [['recharge_money', 'service_money', 'receipt_amount'], 'string', 'max' => 18],
            [['order_no'], 'string', 'max' => 40],
            [['subject'], 'string', 'max' => 256],
            [['body'], 'string', 'max' => 400],
            [['remarks'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', '用户ID'),
            'buit_id' => Yii::t('app', '充值交易类型（buit base_useriotype）'),
            'buyer_id' => Yii::t('app', '买家id'),
            'buyer_logon_id' => Yii::t('app', '买家帐号'),
            'recharge_money' => Yii::t('app', '充值金额'),
            'service_money' => Yii::t('app', '充值手续费'),
            'receipt_amount' => Yii::t('app', '实收金额'),
            'order_no' => Yii::t('app', '订单号'),
            'trade_no' => Yii::t('app', '交易号'),
            'subject' => Yii::t('app', '订单标题'),
            'body' => Yii::t('app', '商品描述'),
            'create_time' => Yii::t('app', '订单创建时间'),
            'pay_time' => Yii::t('app', '付款时间'),
            'notify_time' => Yii::t('app', '交易通知时间'),
            'status' => Yii::t('app', '充值状态(0 交易创建,等待支付;1 支付成功;2交易结束，不可退款,3未付款交易超时关闭)'),
            'remarks' => Yii::t('app', '充值描述'),
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
