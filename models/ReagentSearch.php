<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reagent;

/**
 * ReagentSearch represents the model behind the search form of `app\models\Reagent`.
 */
class ReagentSearch extends Reagent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'qoldiq', 'martalik', 'check', 'notific_count', 'notific_filial', 'price'], 'integer'],
            [['title', 'add1'], 'safe'],
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
        $query = Reagent::find();

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
            'qoldiq' => $this->qoldiq,
            'martalik' => $this->martalik,
            'check' => $this->check,
            'price' => $this->price,
            'notific_count' => $this->notific_count,
            'notific_filial' => $this->notific_filial,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'add1', $this->add1]);

        return $dataProvider;
    }
}
