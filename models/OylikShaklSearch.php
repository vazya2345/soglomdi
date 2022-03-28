<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OylikShakl;

/**
 * OylikShaklSearch represents the model behind the search form of `app\models\OylikShakl`.
 */
class OylikShaklSearch extends OylikShakl
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'oylik_hodimlar_id', 'summa', 'shakl_id'], 'integer'],
            [['fio', 'fil_name', 'lavozim', 'title', 'period'], 'safe'],
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
        $query = OylikShakl::find();

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
            'period' => $this->period,
            'oylik_hodimlar_id' => $this->oylik_hodimlar_id,
            'summa' => $this->summa,
            'shakl_id' => $this->shakl_id,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'fil_name', $this->fil_name])
            ->andFilterWhere(['like', 'lavozim', $this->lavozim])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
