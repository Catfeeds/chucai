<?php

namespace wechat\modules\wechat\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use wechat\modules\wechat\models\WechatEvent;

/**
 * WechatEventSearch represents the model behind the search form about `wechat\modules\wechat\models\WechatEvent`.
 */
class WechatEventSearch extends WechatEvent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'event_key'], 'integer'],
            [['msg_type', 'to_user_name', 'from_user_name', 'event', 'ticket', 'create_time'], 'safe'],
            [['latitude', 'longitude', 'wx_precision'], 'number'],
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
        $query = WechatEvent::find();

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
            'event_key' => $this->event_key,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'wx_precision' => $this->wx_precision,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'msg_type', $this->msg_type])
            ->andFilterWhere(['like', 'to_user_name', $this->to_user_name])
            ->andFilterWhere(['like', 'from_user_name', $this->from_user_name])
            ->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'ticket', $this->ticket]);

        return $dataProvider;
    }
}
