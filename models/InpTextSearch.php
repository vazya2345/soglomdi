<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InpText;

/**
 * InpTextSearch represents the model behind the search form of `app\models\InpText`.
 */
class InpTextSearch extends InpText
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'inptype_id', 'ord'], 'integer'],
            [['input_type', 'input_value', 'add1'], 'safe'],
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
        $query = InpText::find();

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
            'inptype_id' => $this->inptype_id,
            'ord' => $this->ord,
        ]);

        $query->andFilterWhere(['like', 'input_type', $this->input_type])
            ->andFilterWhere(['like', 'input_value', $this->input_value])
            ->andFilterWhere(['like', 'add1', $this->add1]);

        return $dataProvider;
    }
}
