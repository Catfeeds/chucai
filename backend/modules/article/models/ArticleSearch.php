<?php

namespace backend\modules\article\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\article\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `backend\modules\article\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'add_time', 'view', 'share', 'source', 'type', 'status', 'sort', 'cid'], 'integer'],
            [['title', 'abstract', 'content', 'auth', 'art_img', 'chani_url', 'con_url'], 'safe'],
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
        $query = Article::find();

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
            'add_time' => $this->add_time,
            'view' => $this->view,
            'share' => $this->share,
            'source' => $this->source,
            'type' => $this->type,
            'status' => $this->status,
            'sort' => $this->sort,
            'cid' => $this->cid,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'auth', $this->auth])
            ->andFilterWhere(['like', 'art_img', $this->art_img])
            ->andFilterWhere(['like', 'chani_url', $this->chani_url])
            ->andFilterWhere(['like', 'con_url', $this->con_url]);

        return $dataProvider;
    }
}
