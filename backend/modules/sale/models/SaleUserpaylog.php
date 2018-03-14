<?php

namespace backend\modules\sale\models;

use Yii;

/**
 * This is the model class for table "{{%sale_userpaylog}}".
 *
 * @property string $id
 * @property integer $type
 * @property integer $busisort
 * @property integer $busino
 * @property string $pay_make_id
 * @property string $user_id
 * @property string $user_name
 * @property string $order_id
 * @property string $pay_money
 * @property string $pay_poundage
 * @property string $has_pay
 * @property string $add_time
 * @property string $remarks
 * @property string $admin_remarks
 * @property string $admin_name
 * @property integer $status
 */
class SaleUserpaylog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sale_userpaylog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id'], 'required'],
            [['type', 'busisort', 'busino', 'pay_make_id', 'user_id', 'status'], 'integer'],
            [['pay_money', 'pay_poundage', 'has_pay'], 'number'],
            [['add_time'], 'safe'],
            [['user_name', 'order_id'], 'string', 'max' => 50],
            [['remarks', 'admin_remarks'], 'string', 'max' => 200],
            [['admin_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '用户收入支出id'),
            'type' => Yii::t('app', '0进帐 1出帐'),
            'busisort' => Yii::t('app', '大交易类型ID'),
            'busino' => Yii::t('app', '小交易类型ID'),
            'pay_make_id' => Yii::t('app', '触发该笔交易的ID'),
            'user_id' => Yii::t('app', '用户ID'),
            'user_name' => Yii::t('app', '用户名'),
            'order_id' => Yii::t('app', '定单号'),
            'pay_money' => Yii::t('app', '定单金额'),
            'pay_poundage' => Yii::t('app', '定单手续费'),
            'has_pay' => Yii::t('app', '发生该笔定单后的帐户余额'),
            'add_time' => Yii::t('app', '发生时间'),
            'remarks' => Yii::t('app', '定单说明'),
            'admin_remarks' => Yii::t('app', '管理员说明'),
            'admin_name' => Yii::t('app', '管理员名字'),
            'status' => Yii::t('app', '0 未成功 1已成功'),
        ];
    }
}
