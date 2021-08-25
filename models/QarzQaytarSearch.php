<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QarzQaytar;

/**
 * QarzQaytarSearch represents the model behind the search form of `app\models\QarzQaytar`.
 */
class QarzQaytarSearch extends QarzQaytar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reg_id', 'summa_plasitk', 'summa_naqd', 'kassir_id'], 'integer'],
            [['qaytargan_vaqt'], 'safe'],
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
        $query = QarzQaytar::find();

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
            'summa_plasitk' => $this->summa_plasitk,
            'summa_naqd' => $this->summa_naqd,
            'qaytargan_vaqt' => $this->qaytargan_vaqt,
            'kassir_id' => $this->kassir_id,
        ]);

        return $dataProvider;
    }
}
