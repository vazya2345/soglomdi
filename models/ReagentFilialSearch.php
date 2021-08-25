<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReagentFilial;

/**
 * ReagentFilialSearch represents the model behind the search form of `app\models\ReagentFilial`.
 */
class ReagentFilialSearch extends ReagentFilial
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'filial_id', 'reagent_id', 'qoldiq'], 'integer'],
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
        $query = ReagentFilial::find();

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
            'filial_id' => $this->filial_id,
            'reagent_id' => $this->reagent_id,
            'qoldiq' => $this->qoldiq
        ]);

        return $dataProvider;
    }
}
