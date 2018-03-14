<?php

namespace backend\modules\good\models;

use Yii;

/**
 * This is the model class for table "{{%good_imgs}}".
 *
 * @property string $id
 * @property integer $good_id
 * @property string $img_path
 * @property string $create_at
 * @property string $update_at
 */
class GoodImgs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%good_imgs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['good_id', 'img_path', 'create_at', 'update_at'], 'required'],
            [['good_id'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['img_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'good_id' => Yii::t('app', '商品id'),
            'img_path' => Yii::t('app', '图片路径'),
            'create_at' => Yii::t('app', 'Create At'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }

    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'good_id']);
    }
}
