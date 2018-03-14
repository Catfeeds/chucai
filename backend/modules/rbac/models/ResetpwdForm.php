<?php
namespace backend\modules\rbac\models;

use yii\base\Model;
use backend\modules\rbac\models\Adminuser;
//use common\models\User;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{
    public $username;
//    public $email;
    public $password;
    public $password_repeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入的密码不一致！'],
        ];
    }

    public function attributeLabels()
    {
        return [
//            'username' => '用户名',
//            'nickname' => '昵称',
            'password' => '密码',
            'password_repeat'=>'重输密码',
//            'email' => 'Email',
//            'profile' => '简介',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetPassword($id)
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = Adminuser::findOne($id);
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

//        if (!$user->save()) {
//            print_r($user->errors);die;
//        }
        return $user->save() ? true : false;
    }
}
