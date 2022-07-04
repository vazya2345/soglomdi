<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rasxod;

/**
 * RasxodSearch represents the model behind the search form of `app\models\Rasxod`.
 */
class RasxodSearch extends Rasxod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'filial_id', 'user_id', 'referal_id', 'summa', 'sum_type', 'rasxod_type', 'status', 'send_user', 'qabul_hodim_id'], 'integer'],
            [['rasxod_desc', 'rasxod_period', 'create_date', 'mod_date'], 'safe'],
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
        $query = Rasxod::find();

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
            'user_id' => $this->user_id,
            'referal_id' => $this->referal_id,
            'summa' => $this->summa,
            'sum_type' => $this->sum_type,
            'rasxod_type' => $this->rasxod_type,
            'rasxod_period' => $this->rasxod_period,
            'status' => $this->status,
            'send_user' => $this->send_user,
            'qabul_hodim_id' => $this->qabul_hodim_id,
        ]);

        $query->andFilterWhere(['like', 'rasxod_desc', $this->rasxod_desc]);
        $query->andFilterWhere(['like', 'create_date', $this->create_date]);
        $query->andFilterWhere(['like', 'mod_date', $this->mod_date]);

        return $dataProvider;
    }
}
