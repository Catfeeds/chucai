<?php

namespace backend\modules\order\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\order\models\UserOrder;

/**
 * UserOrderSearch represents the model behind the search form about `backend\modules\order\models\UserOrder`.
 */
class UserOrderSearch extends UserOrder
{

    public $name;
    public $title;
    public $start_time;
    public $end_time;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_status', 'user_id', 'good_id'], 'integer'],
            [['order_code', 'create_at', 'update_at','name','title','start_time','end_time'], 'safe'],
            [['amount_money', 'u_money', 'p_money'], 'number'],
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
        $query = UserOrder::find();
        $query->joinWith(['user','good']);
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
            'order_status' => $this->order_status,
            'user_id' => $this->user_id,
            'good_id' => $this->good_id,
            'amount_money' => $this->amount_money,
            'u_money' => $this->u_money,
            'p_money' => $this->p_money,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'order_code', $this->order_code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['>=', 'start_time', $this->create_at])
            ->andFilterWhere(['<=', 'end_time', $this->create_at]);
        return $dataProvider;
    }
}
