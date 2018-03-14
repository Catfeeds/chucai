<?php

namespace backend\modules\base\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\base\models\Vocations;

/**
 * VocationsSearch represents the model behind the search form about `backend\modules\base\models\Vocations`.
 */
class VocationsSearch extends Vocations
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['v_id', 'sort', 'status'], 'integer'],
            [['name'], 'safe'],
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
        $query = Vocations::find();

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
            'v_id' => $this->v_id,
            'sort' => $this->sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
