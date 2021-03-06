<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FilialQoldiq;

/**
 * FilialQoldiqSearch represents the model behind the search form of `app\models\FilialQoldiq`.
 */
class FilialQoldiqSearch extends FilialQoldiq
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'filial_id', 'kassir_id', 'qoldiq', 'qoldiq_type'], 'integer'],
            [['last_change_date'], 'safe'],
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
        $query = FilialQoldiq::find();

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
            'kassir_id' => $this->kassir_id,
            'qoldiq' => $this->qoldiq,
            'qoldiq_type' => $this->qoldiq_type,
            'last_change_date' => $this->last_change_date,
        ]);

        return $dataProvider;
    }
}
