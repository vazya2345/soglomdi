<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Registration;
use app\models\Client;
/**
 * RegistrationSearch represents the model behind the search form of `app\models\Registration`.
 */
class RegistrationSearch extends Registration
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'kassir_id', 'sum_amount', 'sum_cash', 'sum_plastik', 'sum_debt','status'], 'integer'],
            [['client_id', 'ref_code', 'natija_input', 'other', 'tashxis', 'create_date', 'change_time', 'lab_vaqt'], 'safe'],
            [['skidka_reg','skidka_kassa'], 'number'],
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
        $query = Registration::find();

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
            'user_id' => $this->user_id,
            'kassir_id' => $this->kassir_id,
            'sum_amount' => $this->sum_amount,
            'sum_cash' => $this->sum_cash,
            'sum_plastik' => $this->sum_plastik,
            // 'sum_debt' => $this->sum_debt,
            'skidka_reg' => $this->skidka_reg,
            'skidka_kassa' => $this->skidka_kassa,
            'create_date' => $this->create_date,
            'change_time' => $this->change_time,
            'lab_vaqt' => $this->lab_vaqt,
            'status' => $this->status,
        ]);

        if(strlen($this->client_id)>1){
            $query->andWhere(['in','client_id',Client::getArrayByFio($this->client_id)]);
        }
        if($this->sum_debt==1){
            $query->andWhere(['>','sum_debt',0]);
        }

        
        
        $query->andFilterWhere(['like', 'ref_code', $this->ref_code])
            ->andFilterWhere(['like', 'natija_input', $this->natija_input])
            ->andFilterWhere(['like', 'other', $this->other])
            ->andFilterWhere(['like', 'tashxis', $this->tashxis]);

        return $dataProvider;
    }
}
