<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MoneySend;

/**
 * MoneySendSearch represents the model behind the search form of `app\models\MoneySend`.
 */
class MoneySendSearch extends MoneySend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'send_user', 'rec_user', 'amount', 'status', 'desc', 'send_type'], 'integer'],
            [['send_date', 'rec_date'], 'safe'],
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
        $query = MoneySend::find();

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
            'send_user' => $this->send_user,
            'rec_user' => $this->rec_user,
            'amount' => $this->amount,
            'status' => $this->status,
            'send_date' => $this->send_date,
            'rec_date' => $this->rec_date,
            'desc' => $this->desc,
            'send_type' => $this->send_type,
        ]);

        return $dataProvider;
    }
}
