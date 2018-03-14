<?php

namespace backend\modules\sale\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sale\models\SaleUserpaylog;

/**
 * SaleUserpaylogSearch represents the model behind the search form about `backend\modules\sale\models\SaleUserpaylog`.
 */
class SaleUserpaylogSearch extends SaleUserpaylog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'busisort', 'busino', 'pay_make_id', 'user_id', 'status'], 'integer'],
            [['user_name', 'order_id', 'add_time', 'remarks', 'admin_remarks', 'admin_name'], 'safe'],
            [['pay_money', 'pay_poundage', 'has_pay'], 'number'],
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
        $query = SaleUserpaylog::find();

        // add conditions that should always apply here

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 10; //默认20
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  ['pageSize' => $pageSize,],
            'sort' => [
                //设置默认排序
                'defaultOrder' => ['id' => SORT_DESC],
            ]
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
            'type' => $this->type,
            'busisort' => $this->busisort,
            'busino' => $this->busino,
            'pay_make_id' => $this->pay_make_id,
            'user_id' => $this->user_id,
            'pay_money' => $this->pay_money,
            'pay_poundage' => $this->pay_poundage,
            'has_pay' => $this->has_pay,
            'add_time' => $this->add_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'order_id', $this->order_id])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'admin_remarks', $this->admin_remarks])
            ->andFilterWhere(['like', 'admin_name', $this->admin_name]);

        return $dataProvider;
    }
}
