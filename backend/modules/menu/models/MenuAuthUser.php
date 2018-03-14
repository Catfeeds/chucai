<?php

namespace backend\modules\menu\models;

use backend\modules\adminuser\models\Adminuser;
use Yii;


class MenuAuthUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_auth_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['g_id', 'uid'], 'integer'],
//            [['g_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['g_id' => 'id']],
//            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => Adminuser::className(), 'targetAttribute' => ['uid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'g_id' => Yii::t('app', '组id'),
            'uid' => Yii::t('app', '用户id'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getG()
    {
        return $this->hasOne(Menu::className(), ['id' => 'g_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(Adminuser::className(), ['id' => 'uid']);
    }
}
