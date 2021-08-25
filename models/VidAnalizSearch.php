<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VidAnaliz;

/**
 * VidAnalizSearch represents the model behind the search form of `app\models\VidAnaliz`.
 */
class VidAnalizSearch extends VidAnaliz
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'analiz_id', 'type', 'ord'], 'integer'],
            [['title', 'sec_text', 'add1', 'ed_izm', 'kolkach'], 'safe'],
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
        $query = VidAnaliz::find();

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
            'analiz_id' => $this->analiz_id,
            'type' => $this->type,
            'ord' => $this->ord,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'sec_text', $this->sec_text])
            ->andFilterWhere(['like', 'add1', $this->add1])
            ->andFilterWhere(['like', 'ed_izm', $this->ed_izm])
            ->andFilterWhere(['like', 'kolkach', $this->kolkach]);

        return $dataProvider;
    }
}
