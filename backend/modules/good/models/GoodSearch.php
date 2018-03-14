<?php

namespace backend\modules\good\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\good\models\Good;

/**
 * GoodSearch represents the model behind the search form about `backend\modules\good\models\Good`.
 */
class GoodSearch extends Good
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'month_sale_num', 'good_category_id'], 'integer'],
            [['title', 'url', 'passwd', 'intro', 'status', 'create_at', 'update_at', 'admin_name', 'admin_remarks'], 'safe'],
            [['prize', 'prize_youhui'], 'number'],
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
        $query = Good::find();

        // add conditions that should always apply here

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 5; //默认20
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  ['pageSize' => $pageSize,],
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
            'user_id' => $this->user_id,
            'prize' => $this->prize,
            'prize_youhui' => $this->prize_youhui,
            'month_sale_num' => $this->month_sale_num,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'good_category_id' => $this->good_category_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'passwd', $this->passwd])
            ->andFilterWhere(['like', 'intro', $this->intro])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'admin_name', $this->admin_name])
            ->andFilterWhere(['like', 'admin_remarks', $this->admin_remarks]);


        return $dataProvider;
    }
}
