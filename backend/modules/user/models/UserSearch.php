<?php

namespace backend\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\modules\user\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_vest', 'type', 'status', 'token_time'], 'integer'],
            [['phone', 'name', 'email', 'head_img', 'passwd', 'pay_passwd', 'real_name', 'card_code', 'token', 'create_at', 'update_at'], 'safe'],
            [['use_money', 'cur_bonus', 'freez_money'], 'number'],
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
        $query = User::find();

        // add conditions that should always apply here

        $pageSize = isset($params['per-page']) ? intval($params['per-page']) : 10; //默认20
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>  ['pageSize' => $pageSize,],
            'sort' => [
                'defaultOrder' => [
                    'create_at' => SORT_DESC,
                ],
            ],
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
            'is_vest' => $this->is_vest,
            'type' => $this->type,
            'status' => $this->status,
            'use_money' => $this->use_money,
            'cur_bonus' => $this->cur_bonus,
            'freez_money' => $this->freez_money,
            'token_time' => $this->token_time,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'head_img', $this->head_img])
            ->andFilterWhere(['like', 'passwd', $this->passwd])
            ->andFilterWhere(['like', 'pay_passwd', $this->pay_passwd])
            ->andFilterWhere(['like', 'real_name', $this->real_name])
            ->andFilterWhere(['like', 'card_code', $this->card_code])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
