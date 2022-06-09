<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ConsultationDoctorRel;

/**
 * ConsultationDoctorRelSearch represents the model behind the search form of `app\models\ConsultationDoctorRel`.
 */
class ConsultationDoctorRelSearch extends ConsultationDoctorRel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reg_id', 'consultation_doctor_id'], 'integer'],
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
        $query = ConsultationDoctorRel::find();

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
            'consultation_doctor_id' => $this->consultation_doctor_id,
        ]);

        return $dataProvider;
    }
}
