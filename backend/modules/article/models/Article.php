<?php

namespace backend\modules\article\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property string $id
 * @property string $title
 * @property string $abstract
 * @property string $content
 * @property string $auth
 * @property integer $add_time
 * @property integer $view
 * @property integer $share
 * @property string $art_img
 * @property integer $source
 * @property integer $type
 * @property integer $status
 * @property integer $sort
 * @property string $cid
 * @property string $chani_url
 * @property string $con_url
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    public $top;

    public $bot;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'auth'], 'required'],
            [['content'], 'string'],
            [['view', 'share', 'source', 'type', 'status', 'sort', 'cid'], 'integer'],
            [['title', 'auth'], 'string', 'max' => 30],
            [['abstract', 'art_img'], 'string', 'max' => 255],
            [['chani_url', 'con_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '文章表ID'),
            'title' => Yii::t('app', '文章标题'),
            'abstract' => Yii::t('app', '摘要'),
            'content' => Yii::t('app', '内容'),
            'auth' => Yii::t('app', '作者'),
            'add_time' => Yii::t('app', '添加时间'),
            'view' => Yii::t('app', '查看量'),
            'share' => Yii::t('app', '分享数量'),
            'art_img' => Yii::t('app', '文章缩略图'),
            'source' => Yii::t('app', '来源(0.外链，1.内部)'),
            'type' => Yii::t('app', '是否可以分享(1.是,0.否)'),
            'status' => Yii::t('app', '状态(1.开启，0.禁用)'),
            'sort' => Yii::t('app', '排序'),
            'cid' => Yii::t('app', '所属分类'),
            'chani_url' => Yii::t('app', '外部链接(如果是转载，记录转载地址)'),
            'con_url' => Yii::t('app', '生成的模板存储地址'),
        ];
    }

    /**
     * 获取菜单列表
     */
    public static function items(){

        $res_data = array();
        $modles = Category::find()->orderBy('id asc')->all();
        foreach ($modles as $model) {
            if($model->pid == 0){
            $res_data[$model->id] = $model->name;
            }
            else{
                $res_data[$model->id] = '├─ '."$model->name";
            }
        }
//        var_dump($res_data);die;
        return $res_data;

    }
    /**
     * 获取指定值
     */
    public static function item($id){
        $res_data = false;
        $modles = self::find()->where(['id'=>$id])->one();
        if (!empty($modles))
        {
            $res_data = $modles->name;
        }
        return $res_data;
    }
}
