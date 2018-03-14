<?php

namespace backend\modules\base\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\base\models\District;

/**
 * DistrictSearch represents the model behind the search form about `backend\modules\base\models\District`.
 */
class DistrictSearch extends District
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'upid'], 'integer'],
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
        $query = District::find();

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
            'level' => $this->level,
            'upid' => $this->upid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function searchApi($params,$page=0,$limit=10)
    {
        $query = District::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
//                    'create_time' => SORT_DESC,
                    'id'=>SORT_ASC,
                ],
            ],
            'pagination' => [
                'pageSize' => $limit,
                'page'=>$page,
            ],
        ]);

        //  $this->load($params);
        $this->setAttributes($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'level' => $this->level,
            'upid' => $this->upid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function searchApiHospital($params,$page=0,$limit=10)
    {
        $query = District::find();
        $query->joinWith(['hospital'])->groupBy('name')->asArray()->all();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
//                    'create_time' => SORT_DESC,
                    'id'=>SORT_ASC,
                ],
            ],
            'pagination' => [
                'pageSize' => $limit,
                'page'=>$page,
            ],
        ]);

        //  $this->load($params);
        $this->setAttributes($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'district.id' => $this->id,
            'district.level' => $this->level,
            'district.upid' => $this->upid,
        ]);

        $query->andFilterWhere(['like', 'district.name', $this->name]);

        return $dataProvider;
    }
}
