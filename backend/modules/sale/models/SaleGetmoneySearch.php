<?php

namespace backend\modules\sale\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sale\models\SaleGetmoney;

/**
 * SaleGetmoneySearch represents the model behind the search form about `backend\modules\sale\models\SaleGetmoney`.
 */
class SaleGetmoneySearch extends SaleGetmoney
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'cash_type', 'cash_bank_id', 'pay_type'], 'integer'],
            [['name', 'cash_no', 'cash_time', 'cash_card', 'success_time', 'man_remarks', 'pay_username', 'pay_card'], 'safe'],
            [['cash_money', 'case_service_money'], 'number'],
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
        $query = SaleGetmoney::find();

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
            'cash_money' => $this->cash_money,
            'case_service_money' => $this->case_service_money,
            'cash_time' => $this->cash_time,
            'cash_type' => $this->cash_type,
            'cash_bank_id' => $this->cash_bank_id,
            'success_time' => $this->success_time,
            'pay_type' => $this->pay_type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cash_no', $this->cash_no])
            ->andFilterWhere(['like', 'cash_card', $this->cash_card])
            ->andFilterWhere(['like', 'man_remarks', $this->man_remarks])
            ->andFilterWhere(['like', 'pay_username', $this->pay_username])
            ->andFilterWhere(['like', 'pay_card', $this->pay_card]);

        return $dataProvider;

    }
}
