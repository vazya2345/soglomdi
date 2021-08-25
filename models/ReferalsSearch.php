<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Referals;

/**
 * ReferalsSearch represents the model behind the search form of `app\models\Referals`.
 */
class ReferalsSearch extends Referals
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'filial', 'avans_sum'], 'integer'],
            [['fio', 'phone', 'desc', 'info', 'add1', 'refnum'], 'safe'],
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
        $query = Referals::find();

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
            'filial' => $this->filial,
            'avans_sum' => $this->avans_sum,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'add1', $this->add1])
            ->andFilterWhere(['like', 'refnum', $this->refnum]);

        return $dataProvider;
    }
}
