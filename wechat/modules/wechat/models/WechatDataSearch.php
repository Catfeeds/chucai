<?php

namespace wechat\modules\wechat\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use wechat\modules\wechat\models\WechatData;

/**
 * WechatDataSearch represents the model behind the search form about `wechat\modules\wechat\models\WechatData`.
 */
class WechatDataSearch extends WechatData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'msg_id', 'media_id', 'thumb_media_id', 'scale'], 'integer'],
            [['msg_type', 'to_user_name', 'from_user_name', 'content', 'create_time', 'pic_url', 'format', 'recognition', 'label', 'title', 'description', 'url'], 'safe'],
            [['location_x', 'location_y'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WechatData::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'msg_id' => $this->msg_id,
            'create_time' => $this->create_time,
            'media_id' => $this->media_id,
            'thumb_media_id' => $this->thumb_media_id,
            'location_x' => $this->location_x,
            'location_y' => $this->location_y,
            'scale' => $this->scale,
        ]);

        $query->andFilterWhere(['like', 'msg_type', $this->msg_type])
            ->andFilterWhere(['like', 'to_user_name', $this->to_user_name])
            ->andFilterWhere(['like', 'from_user_name', $this->from_user_name])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'pic_url', $this->pic_url])
            ->andFilterWhere(['like', 'format', $this->format])
            ->andFilterWhere(['like', 'recognition', $this->recognition])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
