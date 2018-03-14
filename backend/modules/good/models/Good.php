<?php

namespace backend\modules\good\models;

use Yii;

/**
 * This is the model class for table "{{%good}}".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $title
 * @property string $url
 * @property string $passwd
 * @property string $prize
 * @property string $prize_youhui
 * @property string $intro
 * @property integer $month_sale_num
 * @property string $status
 * @property string $create_at
 * @property string $update_at
 */
class Good extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%good}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'create_at', 'update_at', 'good_category_id'], 'required'],
            [['user_id', 'month_sale_num', 'good_category_id'], 'integer'],
            [['prize', 'prize_youhui'], 'number'],
            [['create_at', 'update_at'], 'safe'],
            [['title'], 'string', 'max' => 15],
            [['url', 'admin_remarks'], 'string', 'max' => 100],
            [['passwd', 'admin_name'], 'string', 'max' => 30],
            [['intro'], 'string', 'max' => 200],
            [['status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', '商品标题'),
            'url' => Yii::t('app', '商品链接'),
            'passwd' => Yii::t('app', '商品密码'),
            'prize' => Yii::t('app', '商品价格'),
            'prize_youhui' => Yii::t('app', '优惠价格'),
            'intro' => Yii::t('app', '商品描述'),
            'month_sale_num' => Yii::t('app', '月销售量'),
            'status' => Yii::t('app', '0 审核中 1审核通过 2审核失败'),
            'create_at' => Yii::t('app', 'Create At'),
            'update_at' => Yii::t('app', 'Update At'),
            'good_category_id' => Yii::t('app', 'Good Category ID'),
            'admin_name' => Yii::t('app', 'Admin Name'),
            'admin_remarks' => Yii::t('app', 'Admin Remarks'),
        ];
    }

    public static function getUid($id){
        $res_data = false;
        $modles = Good::find()->where(['id'=>$id])->one();
        if (!empty($modles))
        {
            $res_data = $modles->title;
        }
        return $res_data;
    }
}
