<?php

namespace app\modules\consultation\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\consultation\models\ConsultationTashhisList;

/**
 * ConsultationTashhisListSearch represents the model behind the search form of `app\modules\consultation\models\ConsultationTashhisList`.
 */
class ConsultationTashhisListSearch extends ConsultationTashhisList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'info', 'group'], 'safe'],
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
        $query = ConsultationTashhisList::find();

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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'group', $this->group]);

        return $dataProvider;
    }
}
