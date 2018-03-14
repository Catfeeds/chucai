<?php

namespace backend\modules\good\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\good\models\GoodImgs;

/**
 * GoodImgsSearch represents the model behind the search form about `backend\modules\good\models\GoodImgs`.
 */
class GoodImgsSearch extends GoodImgs
{
    public $title;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'good_id'], 'integer'],
            [['img_path', 'create_at', 'update_at','title'], 'safe'],
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
        $query = GoodImgs::find();
        $query->joinWith(['good']);
        // add conditions that should always apply here

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 10; //默认20
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
            'good_id' => $this->good_id,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'img_path', $this->img_path])
        ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
