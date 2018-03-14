<?php

namespace backend\modules\sale\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sale\models\SaleBanktmp;

/**
 * SaleBanktmpSearch represents the model behind the search form about `backend\modules\sale\models\SaleBanktmp`.
 */
class SaleBanktmpSearch extends SaleBanktmp
{

    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'buit_id', 'status'], 'integer'],
            [['buyer_id', 'buyer_logon_id', 'recharge_money', 'service_money', 'receipt_amount', 'order_no', 'trade_no', 'subject', 'body', 'create_time', 'pay_time', 'notify_time', 'remarks'], 'safe'],
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
        $query = SaleBanktmp::find();
        $query ->joinWith(['user']);
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
            'user_id' => $this->user_id,
            'buit_id' => $this->buit_id,
            'create_time' => $this->create_time,
            'pay_time' => $this->pay_time,
            'notify_time' => $this->notify_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'buyer_id', $this->buyer_id])
            ->andFilterWhere(['like', 'buyer_logon_id', $this->buyer_logon_id])
            ->andFilterWhere(['like', 'recharge_money', $this->recharge_money])
            ->andFilterWhere(['like', 'service_money', $this->service_money])
            ->andFilterWhere(['like', 'receipt_amount', $this->receipt_amount])
            ->andFilterWhere(['like', 'order_no', $this->order_no])
            ->andFilterWhere(['like', 'trade_no', $this->trade_no])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
