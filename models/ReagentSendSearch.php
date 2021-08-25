<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReagentSend;

/**
 * ReagentSendSearch represents the model behind the search form of `app\models\ReagentSend`.
 */
class ReagentSendSearch extends ReagentSend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reagent_id', 'filial_id', 'soni'], 'integer'],
            [['send_date', 'comment'], 'safe'],
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
        $query = ReagentSend::find();

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
            'reagent_id' => $this->reagent_id,
            'filial_id' => $this->filial_id,
            'soni' => $this->soni,
            'send_date' => $this->send_date,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
