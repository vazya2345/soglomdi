<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefSends;

/**
 * RefSendsSearch represents the model behind the search form of `app\models\RefSends`.
 */
class RefSendsSearch extends RefSends
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sum', 'status', 'user_id'], 'integer'],
            [['refnum', 'send_date', 'rec_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = RefSends::find();

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
            'sum' => $this->sum,
            'status' => $this->status,
            'send_date' => $this->send_date,
            'rec_date' => $this->rec_date,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'refnum', $this->refnum]);

        return $dataProvider;
    }
}
