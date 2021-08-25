<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PokazLimits;

/**
 * PokazLimitsSearch represents the model behind the search form of `app\models\PokazLimits`.
 */
class PokazLimitsSearch extends PokazLimits
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pokaz_id'], 'integer'],
            [['indikator', 'indikator_value', 'norma', 'down_limit', 'up_limit', 'add1'], 'safe'],
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
        $query = PokazLimits::find();

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
            'pokaz_id' => $this->pokaz_id,
        ]);

        $query->andFilterWhere(['like', 'indikator', $this->indikator])
            ->andFilterWhere(['like', 'indikator_value', $this->indikator_value])
            ->andFilterWhere(['like', 'norma', $this->norma])
            ->andFilterWhere(['like', 'down_limit', $this->down_limit])
            ->andFilterWhere(['like', 'up_limit', $this->up_limit])
            ->andFilterWhere(['like', 'add1', $this->add1]);

        return $dataProvider;
    }
}
