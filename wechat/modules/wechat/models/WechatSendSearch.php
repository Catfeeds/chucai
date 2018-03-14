<?php

namespace wechat\modules\wechat\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use wechat\modules\wechat\models\WechatSend;

/**
 * WechatSendSearch represents the model behind the search form about `wechat\modules\wechat\models\WechatSend`.
 */
class WechatSendSearch extends WechatSend
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'url', 'template_id', 'first_value', 'first_color', 'keyword1_value', 'keyword1_color', 'keyword2_value', 'keyword2_color', 'keyword3_value', 'keyword3_color', 'keyword4_value', 'keyword4_color', 'keyword5_value', 'keyword5_color', 'keyword6_value', 'keyword6_color', 'remark_value', 'remark_color'], 'safe'],
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
        $query = WechatSend::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'template_id', $this->template_id])
            ->andFilterWhere(['like', 'first_value', $this->first_value])
            ->andFilterWhere(['like', 'first_color', $this->first_color])
            ->andFilterWhere(['like', 'keyword1_value', $this->keyword1_value])
            ->andFilterWhere(['like', 'keyword1_color', $this->keyword1_color])
            ->andFilterWhere(['like', 'keyword2_value', $this->keyword2_value])
            ->andFilterWhere(['like', 'keyword2_color', $this->keyword2_color])
            ->andFilterWhere(['like', 'keyword3_value', $this->keyword3_value])
            ->andFilterWhere(['like', 'keyword3_color', $this->keyword3_color])
            ->andFilterWhere(['like', 'keyword4_value', $this->keyword4_value])
            ->andFilterWhere(['like', 'keyword4_color', $this->keyword4_color])
            ->andFilterWhere(['like', 'keyword5_value', $this->keyword5_value])
            ->andFilterWhere(['like', 'keyword5_color', $this->keyword5_color])
            ->andFilterWhere(['like', 'keyword6_value', $this->keyword6_value])
            ->andFilterWhere(['like', 'keyword6_color', $this->keyword6_color])
            ->andFilterWhere(['like', 'remark_value', $this->remark_value])
            ->andFilterWhere(['like', 'remark_color', $this->remark_color]);

        return $dataProvider;
    }
}
