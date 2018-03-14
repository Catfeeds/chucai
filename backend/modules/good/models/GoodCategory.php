<?php

namespace backend\modules\good\models;

use Yii;

/**
 * This is the model class for table "{{%good_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $img_path
 * @property integer $status
 * @property string $create_at
 * @property string $update_at
 */
class GoodCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%good_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'img_path', 'status'], 'required'],
            [['status'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['name'], 'string', 'max' => 10],
            [['img_path'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'img_path' => Yii::t('app', 'Img Path'),
            'status' => Yii::t('app', '1 启用 0 禁用'),
            'create_at' => Yii::t('app', 'Create At'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }
}
