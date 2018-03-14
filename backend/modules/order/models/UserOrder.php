<?php

namespace backend\modules\order\models;

use backend\modules\good\models\Good;
use backend\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%user_order}}".
 *
 * @property string $id
 * @property string $order_code
 * @property integer $order_status
 * @property string $user_id
 * @property integer $good_id
 * @property string $amount_money
 * @property string $u_money
 * @property string $p_money
 * @property string $create_at
 * @property string $update_at
 */
class UserOrder extends \yii\db\ActiveRecord
{
    private static $_item_arr;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_status', 'user_id', 'good_id'], 'integer'],
            [['good_id', 'create_at', 'update_at'], 'required'],
            [['amount_money', 'u_money', 'p_money'], 'number'],
            [['create_at', 'update_at'], 'safe'],
            [['order_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '订单id'),
            'order_code' => Yii::t('app', '订单编号,供用户查找订单,如:DG201011261723520547'),
            'order_status' => Yii::t('app', '0 订单未支付  1订单已支付 2订单已支付但超过订购时间，失效'),
            'user_id' => Yii::t('app', '用户id'),
            'good_id' => Yii::t('app', '商品id'),
            'amount_money' => Yii::t('app', '订单总金额'),
            'u_money' => Yii::t('app', '用户赚金额'),
            'p_money' => Yii::t('app', '平台收取金额'),
            'create_at' => Yii::t('app', 'Create At'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }

    public static function getUid($id){
        $res_data = false;
        $modles = User::find()->where(['id'=>$id])->one();
        if (!empty($modles))
        {
            $res_data = $modles->name;
        }
        return $res_data;
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }

}
