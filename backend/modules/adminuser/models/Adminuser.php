<?php

namespace backend\modules\adminuser\models;

use Yii;

/**
 * This is the model class for table "{{%adminuser}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $role
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Adminuser extends \yii\db\ActiveRecord
{
    public $menu_auth_id;  //菜单权限主键
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%adminuser}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash',  'email'], 'required'],
            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 60],
            [['password_reset_token'], 'string', 'max' => 43],
            [['email'], 'trim'],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '登录账号'),
            'password_hash' => Yii::t('app', '密码'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'role' => Yii::t('app', 'Role'),
            'email' => Yii::t('app', '邮箱地址'),
            'status' => Yii::t('app', '是否启用'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }

    /**
     * 获取菜单列表
     */
    public static function items(){
        $data = self::find()->asArray()->all();
        $arr = [];
        foreach ($data as $item) {
            $arr[$item['id']] = $item['username'];
        }

        return $arr;
    }

    public static function item($id){
        $res_data = false;
        $modles = self::find()->where(['id'=>$id])->one();
        if (!empty($modles))
        {
            $res_data = $modles->username;
        }
        return $res_data;
    }


    public function beforeSave($insert)
    {
        $this->created_at = time();
        $this->updated_at = time();

        if (strlen($this->password_hash) != 60)
        {
            $this->role = 10;
            $this->status = 10;
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();

        }
        return parent::beforeSave($insert);
    }
}
