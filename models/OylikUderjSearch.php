<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OylikUderj;

/**
 * OylikUderjSearch represents the model behind the search form of `app\models\OylikUderj`.
 */
class OylikUderjSearch extends OylikUderj
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'oylik_hodimlar_id', 'summa', 'period', 'create_userid'], 'integer'],
            [['title', 'create_date'], 'safe'],
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
        $query = OylikUderj::find();

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
            'oylik_hodimlar_id' => $this->oylik_hodimlar_id,
            'summa' => $this->summa,
            'period' => $this->period,
            'create_date' => $this->create_date,
            'create_userid' => $this->create_userid,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
