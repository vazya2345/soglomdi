<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OylikHodimlar;

/**
 * OylikHodimlarSearch represents the model behind the search form of `app\models\OylikHodimlar`.
 */
class OylikHodimlarSearch extends OylikHodimlar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'summa', 'filial_id', 'lavozim'], 'integer'],
            [['fio', 'other_info', 'create_date'], 'safe'],
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
        $query = OylikHodimlar::find();

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
            'summa' => $this->summa,
            'filial_id' => $this->filial_id,
            'lavozim' => $this->lavozim,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'other_info', $this->other_info]);

        return $dataProvider;
    }
}
