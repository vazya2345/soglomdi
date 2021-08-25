<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Result;

/**
 * ResultSearch represents the model behind the search form of `app\models\Result`.
 */
class ResultSearch extends Result
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'main_id', 'analiz_id', 'pokaz_id', 'user_id'], 'integer'],
            [['reslut_value', 'result_answer', 'create_date'], 'safe'],
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
        $query = Result::find();

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
            'main_id' => $this->main_id,
            'analiz_id' => $this->analiz_id,
            'pokaz_id' => $this->pokaz_id,
            'create_date' => $this->create_date,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'reslut_value', $this->reslut_value])
            ->andFilterWhere(['like', 'result_answer', $this->result_answer]);

        return $dataProvider;
    }
}
