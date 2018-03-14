<?php

namespace backend\modules\base\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\base\models\ActionLog;

/**
 * ActionLogSearch represents the model behind the search form about `backend\modules\base\models\ActionLog`.
 */
class ActionLogSearch extends ActionLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'type', 'status', 'recorid'], 'integer'],
            [['name', 'action_ip', 'title', 'remark', 'create_time', 'model'], 'safe'],
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
        $query = ActionLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'create_time' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);
        /**
         * 权限验证
         */
        if (Yii::$app->user->identity->id != 10000)
        {
            $this->uid = Yii::$app->user->identity->id;
        } 
        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'type' => $this->type,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'recorid' => $this->recorid,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'action_ip', $this->action_ip])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'model', $this->model]);

        return $dataProvider;
    }
}
