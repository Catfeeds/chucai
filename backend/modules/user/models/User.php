<?php

namespace backend\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $phone
 * @property string $name
 * @property string $email
 * @property integer $is_vest
 * @property string $head_img
 * @property string $passwd
 * @property string $pay_passwd
 * @property string $real_name
 * @property string $card_code
 * @property integer $type
 * @property integer $status
 * @property string $use_money
 * @property string $cur_bonus
 * @property string $freez_money
 * @property string $token
 * @property string $token_time
 * @property string $create_at
 * @property string $update_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'name', 'email', 'head_img', 'passwd', 'type', 'token_time', 'create_at', 'update_at'], 'required'],
            [['is_vest', 'type', 'status', 'token_time'], 'integer'],
            [['use_money', 'cur_bonus', 'freez_money'], 'number'],
            [['create_at', 'update_at'], 'safe'],
            [['phone'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 30],
            [['head_img'], 'string', 'max' => 250],
            [['passwd', 'pay_passwd'], 'string', 'max' => 100],
            [['real_name'], 'string', 'max' => 10],
            [['card_code'], 'string', 'max' => 25],
            [['token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => Yii::t('app', '手机号，作为登录帐号'),
            'name' => Yii::t('app', '用户名'),
            'email' => Yii::t('app', '邮箱'),
            'is_vest' => Yii::t('app', '0普通用户 1内部用户'),
            'head_img' => Yii::t('app', '头像连接'),
            'passwd' => Yii::t('app', '登录密码'),
            'pay_passwd' => Yii::t('app', '支付密码'),
            'real_name' => Yii::t('app', '真实姓名'),
            'card_code' => Yii::t('app', '身份证'),
            'type' => Yii::t('app', '1安卓 2苹果 3pc'),
            'status' => Yii::t('app', '用户状态:1 正常,2 锁定 3 注销'),
            'use_money' => Yii::t('app', '可用资金(充值获得)'),
            'cur_bonus' => Yii::t('app', '当前奖金(可体现)'),
            'freez_money' => Yii::t('app', '冻结金额'),
            'token' => Yii::t('app', 'Token'),
            'token_time' => Yii::t('app', '生成token时间，判断是否过期'),
            'create_at' => Yii::t('app', 'Create At'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }
}
