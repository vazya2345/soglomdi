<?php

namespace app\modules\consultation\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\consultation\models\ConsultationMain;

/**
 * ConsultationMainSearch represents the model behind the search form of `app\modules\consultation\models\ConsultationMain`.
 */
class ConsultationMainSearch extends ConsultationMain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reg_id'], 'integer'],
            [['consultation_type', 'value'], 'safe'],
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
        $query = ConsultationMain::find();

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
            'reg_id' => $this->reg_id,
        ]);

        $query->andFilterWhere(['like', 'consultation_type', $this->consultation_type])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
